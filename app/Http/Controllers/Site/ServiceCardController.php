<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\ServiceCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreServiceCardRequest;
use App\Mail\ServiceCard\AppliedMail;

class ServiceCardController extends Controller
{
    public function create()
    {
        $bps = [];
        for ($i = 1; $i <= 20; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $cat = [
            'designations' => Category::where('type', 'designation')
                ->whereNotIn('name', ['Secretary', 'Minister'])
                ->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => $bps,
            'blood_groups' => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"]
        ];
        
        return view('site.service_cards.create', compact('cat'));
    }

    public function store(StoreServiceCardRequest $request)
    {
        $card = new ServiceCard();
        $card->name = $request->name;
        $card->father_name = $request->father_name;
        $card->cnic = $request->cnic;
        $card->date_of_birth = $request->date_of_birth;
        $card->email = $request->email;
        $card->mobile_number = $request->mobile_number;
        $card->landline_number = $request->landline_number;
        $card->personnel_number = $request->personnel_number;
        $card->mark_of_identification = $request->mark_of_identification;
        $card->blood_group = $request->blood_group;
        $card->emergency_contact = $request->emergency_contact;
        $card->parmanent_address = $request->parmanent_address;
        $card->present_address = $request->present_address;
        $card->designation = $request->designation;
        $card->bps = $request->bps;
        $card->office = $request->office;
        $card->status = 'New';

        if ($request->hasFile('profile_picture')) {
            $card->addMedia($request->file('profile_picture'))
                ->toMediaCollection('service_card_pictures');
        }

        if ($card->save()) {
            Mail::to($card->email)->queue(new AppliedMail($card));
            return redirect()->route('service_cards.create')->with('success', 'Your ID card information has been submitted. We will notify you once your information is verified.');
        }
        return redirect()->route('service_cards.create')->with('error', 'There is an error submitting your data');
    }

    public function verified(Request $request, $cardId)
    {
        $service_card = ServiceCard::findOrFail($cardId);
        return view('site.service_cards.verified', compact('service_card'));
    }
}
