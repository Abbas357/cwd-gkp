<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicContactRequest;

use App\Models\PublicContact;

use Illuminate\Support\Facades\Mail;
use App\Mail\QuerySubmittedMail;

use Jenssegers\Agent\Agent;

class PublicContactController extends Controller
{
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
}
