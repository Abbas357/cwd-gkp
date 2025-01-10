<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\District;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use App\Mail\Contractor\RenewedMail;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contractor\ApprovedMail;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\ContractorRegistration;
use App\Mail\Contractor\DeferredFirstMail;
use App\Mail\Contractor\DeferredThirdMail;
use App\Mail\Contractor\DeferredSecondMail;
use App\Http\Requests\StoreContractorRegistrationRequest;

class ContractorRegistrationController extends Controller
{
    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $ContractorRegistration->deffered_reason = $request->reason;
        if ($ContractorRegistration->status == "fresh") {
            $ContractorRegistration->status = "deffered_one";
            // Mail::to($ContractorRegistration->email)->queue(new DeferredFirstMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_one") {
            $ContractorRegistration->status = "deffered_two";
            // Mail::to($ContractorRegistration->email)->queue(new DeferredSecondMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_two") {
            $ContractorRegistration->status = "deffered_three";;
            // Mail::to($ContractorRegistration->email)->queue(new DeferredThirdMail($ContractorRegistration, $request->reason));
        }
        if($ContractorRegistration->save()) {
            return response()->json(['success' => 'Contractor has been deferred successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if (!in_array($ContractorRegistration->status, ["deffered_three", 'approved'])) {
            $ContractorRegistration->status = 'approved';
            $ContractorRegistration->card_issue_date = Carbon::now();
            $ContractorRegistration->card_expiry_date = Carbon::now()->addYears(1);
            $ContractorRegistration->save();
            // Mail::to($ContractorRegistration->email)->queue(new ApprovedMail($ContractorRegistration));
            return response()->json(['success' => 'Contractor has been approved successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be approved.']);
    }

    public function renew(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $currentDate = Carbon::now();

        if ($ContractorRegistration->status === 'approved') {
            if ($currentDate->greaterThanOrEqualTo($ContractorRegistration->card_expiry_date)) {
                $ContractorRegistration->card_issue_date = $request->issue_date ?? $currentDate;
                $ContractorRegistration->card_expiry_date = Carbon::parse($ContractorRegistration->card_issue_date)->addYears(1);

                if ($ContractorRegistration->save()) {
                    // Mail::to($ContractorRegistration->email)->queue(new RenewedMail($ContractorRegistration));
                    return response()->json(['success' => 'Contractor card has been renewed successfully.']);
                } else {
                    return response()->json(['error' => 'An error occurred while saving the card data. Please try again.']);
                }
            } else {
                return response()->json(['error' => 'Contractor card cannot be renewed because it has not yet expired.']);
            }
        } else {
            return response()->json(['error' => 'Contractor card status does not allow renewal.']);
        }
    }

    public function show(ContractorRegistration $ContractorRegistration)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $ContractorRegistration,
            ],
        ]);
    }

    public function showDetail(ContractorRegistration $ContractorRegistration)
    {
        $cat = [
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];

        if (!$ContractorRegistration) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('admin.contractors.registrations.partials.detail', compact('Contractor', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(ContractorRegistration $ContractorRegistration)
    {
        if ($ContractorRegistration->status !== 'approved') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Contractor is not verified',
                ],
            ]);
        }
        $data = route('contractors.approved', ['id' => $ContractorRegistration->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.contractors.registrations.partials.card', compact('Contractor', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
}
