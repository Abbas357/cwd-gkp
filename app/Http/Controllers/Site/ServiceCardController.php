<?php

namespace App\Http\Controllers\Site;

use App\Models\ServiceCard;
use App\Http\Controllers\Controller;

class ServiceCardController extends Controller
{
    public function verified($uuid)
    {
        $serviceCard = ServiceCard::where('uuid', $uuid)
            ->where('approval_status', 'verified')
            ->with(['user.profile', 'user.currentDesignation', 'user.currentOffice'])
            ->first();
        return view('site.service_cards.verified', compact('serviceCard'));
    }
}
