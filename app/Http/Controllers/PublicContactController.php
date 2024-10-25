<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;
use App\Models\PublicContact;
use App\Mail\QueryDroppedMail;
use App\Mail\QuerySubmittedMail;
use Yajra\DataTables\DataTables;
use App\Mail\QueryReliefGrantedMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\QueryReliefNotGrantedMail;
use App\Http\Requests\StorePublicContactRequest;

class PublicContactController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $public_contacts = PublicContact::query()->latest('id');

        $public_contacts->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($public_contacts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.public_contacts.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('status', function ($row) {
                    return view('admin.public_contacts.partials.status', compact('row'))->render();
                })
                ->rawColumns(['action','status']);
            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.public_contacts.index');
    }

    public function store(StorePublicContactRequest $request)
    {
        $public_contact = new PublicContact();
        $public_contact->name = $request->name;
        $public_contact->email = $request->email;
        $public_contact->contact_number = $request->contact_number;
        $public_contact->cnic = $request->cnic;
        $public_contact->message = $request->message;
        $public_contact->ip_address = $request->ip();
        $userAgent = $request->header('User-Agent');
        $public_contact->device_info = $this->getDeviceInfo($userAgent);
        if($public_contact->save()) {
            Mail::to($public_contact->email)->queue(new QuerySubmittedMail($public_contact));
            return redirect()->back()->with('success', 'Your message has been sent successfully! You will be informed via Email about your query Status');
        }
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

    public function reliefGrant(Request $request, PublicContact $PublicContact)
    {
        if ($PublicContact->status === 'new') {
            $PublicContact->status = 'relief-granted';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new QueryReliefGrantedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Relief Granted.']);
            }
        }
    }

    public function reliefNotGrant(Request $request, PublicContact $PublicContact)
    {
        if ($PublicContact->status === 'new') {
            $PublicContact->status = 'relief-not-granted';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new QueryReliefNotGrantedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Relief Not Granted.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function drop(Request $request, PublicContact $PublicContact)
    {
        if ($PublicContact->status === 'new') {
            $PublicContact->status = 'dropped';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new QueryDroppedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Dropped.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }
}
