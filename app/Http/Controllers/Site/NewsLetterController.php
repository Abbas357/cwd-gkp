<?php

namespace App\Http\Controllers\Site;

use Carbon\Carbon;
use App\Models\NewsLetter;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter\SubscriptionConfirmation;

class NewsLetterController extends Controller
{
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
}
