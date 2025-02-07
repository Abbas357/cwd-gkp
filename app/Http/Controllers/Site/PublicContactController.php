<?php

namespace App\Http\Controllers\Site;

use Jenssegers\Agent\Agent;
use App\Models\PublicContact;

use App\Mail\Query\SubmittedMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePublicContactRequest;

class PublicContactController extends Controller
{
    public function store(StorePublicContactRequest $request)
    {
        $public_contact = new PublicContact();
        
        $public_contact->name = strip_tags($request->input('name'));
        $public_contact->email = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
        $public_contact->contact_number = strip_tags($request->input('contact_number'));
        $public_contact->cnic = strip_tags($request->input('cnic'));
        $public_contact->message = strip_tags($request->input('message'));
        
        $public_contact->ip_address = $request->ip();
        $userAgent = $request->header('User-Agent');
        $public_contact->device_info = $this->getDeviceInfo($userAgent);
        
        if ($public_contact->save()) {
            Mail::to($public_contact->email)
                ->queue(new SubmittedMail($public_contact));
                
            return redirect()->back()
                ->with('success', 'Your message has been sent successfully! You will be informed via Email about your query Status');
        }

        return redirect()->back()->with('error', 'There was an issue sending your message.');
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
