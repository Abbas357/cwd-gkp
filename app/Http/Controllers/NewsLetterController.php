<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\NewsLetter;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;
use Yajra\DataTables\DataTables;
use App\Mail\MassNewsletterEmail;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $newsletters = NewsLetter::query()->latest('id')->withoutGlobalScope('subscribed');

        $newsletters->when($status !== null, function ($query) use ($status) {
            if ((int) $status === 0) {
                $query->whereNull('unsubscribe_token');
            } elseif ((int) $status === 1) {
                $query->whereNotNull('unsubscribe_token');
            }
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($newsletters)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('admin.newsletters.partials.status', compact('row'))->render();
                })
                ->editColumn('subscribed_at', function ($row) {
                    return $row->subscribed_at->format('j, F Y');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->rawColumns(['status']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.newsletters.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:news_letters,email',
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $deviceInfo = $this->getDeviceInfo($userAgent);

        $unsubscribeToken = Str::random(32);

        Newsletter::create([
            'email' => $request->email,
            'subscribed_at' => Carbon::now(),
            'unsubscribe_token' => $unsubscribeToken,
            'ip_address' => $ipAddress,
            'device_info' => $deviceInfo,
        ]);

        Mail::to($request->email)->send(new SubscriptionConfirmation($unsubscribeToken));

        return redirect()->back()->with('success', 'You have have successfully subscribe to our newsletter. You can always unsubscribe via unsubscribe link in your inbox!');
    }

    private function getDeviceInfo($userAgent)
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $deviceType = $agent->isMobile() ? 'Mobile' : 'Desktop';

        return "Device: {$device}, {$deviceType}, Platform: {$platform}, Browser: {$browser}";
    }

    public function unsubscribe($token)
    {
        $subscriber = Newsletter::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return redirect()->back()->with('error', 'Invalid unsubscribe token.');
        }

        $subscriber->update([
            'unsubscribed_at' => Carbon::now(),
            'unsubscribe_token' => null
        ]);

        return redirect()->route('site')->with('success', 'You have successfully unsubscribed. You will not receive any email from C&W Department in future. (^_^)');
    }

    public function createMassEmail()
    {
        return view('admin.newsletters.create_mass_email');
    }

    public function sendMassEmail(Request $request)
    {
        $request->validate([
            'email_content' => 'required',
            'send_as_queue' => 'required|in:yes,no',
            'attachment' => 'nullable|file',
        ]);

        $emailContent = $request->input('email_content');
        $sendAsQueue = $request->input('send_as_queue') === 'yes';
        $attachment = $request->file('attachment');

        NewsLetter::whereNull('unsubscribed_at')->chunk(100, function ($subscribers) use ($emailContent, $sendAsQueue, $attachment) {
            foreach ($subscribers as $subscriber) {

                if (empty($subscriber->unsubscribe_token)) {
                    $subscriber->unsubscribe_token = Str::random(32);
                    $subscriber->save();
                }

                $unsubscribeLink = route('newsletter.unsubscribe', ['token' => $subscriber->unsubscribe_token]);

                $mailable = new MassNewsletterEmail($emailContent, $unsubscribeLink);

                if ($attachment) {
                    $mailable->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getMimeType(),
                    ]);
                }

                if ($sendAsQueue) {
                    Mail::to($subscriber->email)->queue($mailable);
                } else {
                    Mail::to($subscriber->email)->send($mailable);
                }
            }
        });

        return redirect()->back()->with('success', 'Newsletter emails have been sent successfully.');
    }
}
