<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\ServiceCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCard\RenewedMail;

use Endroid\QrCode\Encoding\Encoding;
use App\Mail\ServiceCard\RejectedMail;
use App\Mail\ServiceCard\VerifiedMail;

class ServiceCardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $service_cards = ServiceCard::query();

        $service_cards->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });


        if ($request->ajax()) {
            $dataTable = Datatables::of($service_cards)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.service_cards.partials.buttons', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;"><img style="width: 30px; height: 30px; border-radius: 50%;" src="' . $row->getFirstMediaUrl('service_card_pictures') . '" /> <span> &nbsp; ' . $row->name . '</span></div>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'name']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.service_cards.index');
    }

    public function show(ServiceCard $service_card)
    {
        return response()->json($service_card);
    }

    public function verify(Request $request, ServiceCard $service_card)
    {
        if ($service_card->status !== 'verified') {
            $service_card->status = 'verified';
            $service_card->issue_date = Carbon::now();
            $service_card->expiry_date = Carbon::now()->addYears(3);
            if ($service_card->save()) {
                Mail::to($service_card->email)->queue(new VerifiedMail($service_card));
                return response()->json(['success' => 'Service Card has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be verified.']);
    }

    public function restore(Request $request, ServiceCard $service_card)
    {
        if ($service_card->status === 'rejected') {
            $service_card->status = 'draft';
            if ($service_card->save()) {
                return response()->json(['success' => 'Service Card has been restored successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be restored.']);
    }

    public function reject(Request $request, ServiceCard $service_card)
    {
        if (!in_array($service_card->status, ['verified', 'rejected'])) {
            $service_card->status = 'rejected';
            $service_card->rejection_reason = $request->reason;

            if ($service_card->save()) {
                Mail::to($service_card->email)->queue(new RejectedMail($service_card, $request->reason));
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function renew(Request $request, ServiceCard $service_card)
    {
        $currentDate = Carbon::now();
        if ($service_card->status === 'verified') {
            if ($currentDate->greaterThanOrEqualTo($service_card->expiry_date)) {
                $service_card->issue_date = $request->issue_date ?? $currentDate;
                $service_card->expiry_date = Carbon::parse($service_card->issue_date)->addYears(3);

                if ($service_card->save()) {
                    Mail::to($service_card->email)->queue(new RenewedMail($service_card));
                    return response()->json(['success' => 'Service Card has been renewed successfully.']);
                } else {
                    return response()->json(['error' => 'An error occurred while saving the card data. Please try again.']);
                }
            } else {
                return response()->json(['error' => 'Service Card is not expired yet.']);
            }
        } else {
            return response()->json(['error' => 'Service Card status does not allow renewal.']);
        }
    }

    public function showDetail(ServiceCard $service_card)
    {
        if (!$service_card) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Card Detail',
                ],
            ]);
        }

        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'positions' => Category::where('type', 'position')->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => $bps,
            'blood_groups' => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"]
        ];

        $html = view('admin.service_cards.partials.details', compact('service_card', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(ServiceCard $service_card)
    {
        if ($service_card->status !== 'verified') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Service Card is not verified',
                ],
            ]);
        }

        $data = route('service_cards.verified', ['uuid' => $service_card->uuid]);
        $qrCode = Builder::create()
            ->writer(new SvgWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.service_cards.partials.card', compact('service_card', 'qrCodeUri'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ServiceCard $service_card)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($service_card->status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'verified or rejected Cards cannot be updated'], 403);
        }

        $service_card->{$request->field} = $request->value;

        if ($service_card->isDirty($request->field)) {
            $service_card->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, ServiceCard $service_card)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        if (in_array($service_card->status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'verified or rejected Cards cannot be updated'], 403);
        }

        try {
            $service_card->addMedia($request->file('image'))
                ->toMediaCollection('service_card_pictures');

            return response()->json(['success' => 'Image uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }
}
