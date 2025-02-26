<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\ServiceCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
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
                    return view('modules.service_cards.partials.buttons', compact('row'))->render();
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

        return view('modules.service_cards.index');
    }

    public function show(ServiceCard $ServiceCard)
    {
        return response()->json($ServiceCard);
    }

    public function verify(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status !== 'verified') {
            $ServiceCard->status = 'verified';
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be verified.']);
    }

    public function restore(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status === 'rejected') {
            $ServiceCard->status = 'draft';
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been restored successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be restored.']);
    }

    public function reject(Request $request, ServiceCard $ServiceCard)
    {
        if (!in_array($ServiceCard->status, ['verified', 'rejected'])) {
            $ServiceCard->status = 'rejected';
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function renew(Request $request, ServiceCard $ServiceCard)
    {
        $currentDate = Carbon::now();
        $latestCard = $ServiceCard->getLatestCard();

        if (!$latestCard) {
            return response()->json(['error' => 'No active card found for renewal.']);
        }
        
        $ServiceCard->cards()->where('status', 'active')->update(['status' => 'expired']);

        if ($currentDate->greaterThanOrEqualTo($latestCard->expiry_date)) {
            $ServiceCard->cards()->create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'issue_date' => $currentDate,
                'expiry_date' => $currentDate->addYear(),
                'status' => 'active',
            ]);
            
            Mail::to($ServiceCard->email)->queue(new RenewedMail($ServiceCard));

            return response()->json(['success' => 'Service Card has been renewed successfully.']);
        } else {
            return response()->json(['error' => 'Service Card cannot be renewed because it has not yet expired.']);
        }
    }

    public function showDetail(ServiceCard $ServiceCard)
    {
        if (!$ServiceCard) {
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

        $html = view('modules.service_cards.partials.details', compact('ServiceCard', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status !== 'verified') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Service Card is not verified',
                ],
            ]);
        }

        $data = route('service_cards.verified', ['uuid' => $ServiceCard->uuid]);
        $qrCode = Builder::create()
            ->writer(new SvgWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('modules.service_cards.partials.card', compact('ServiceCard', 'qrCodeUri'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($ServiceCard->status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'verified or rejected Cards cannot be updated'], 403);
        }

        $ServiceCard->{$request->field} = $request->value;

        if ($ServiceCard->isDirty($request->field)) {
            $ServiceCard->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        if (in_array($ServiceCard->status, ['verified', 'rejected'])) {
            return response()->json(['error' => 'verified or rejected Cards cannot be updated'], 403);
        }

        try {
            $ServiceCard->addMedia($request->file('image'))
                ->toMediaCollection('service_card_pictures');

            return response()->json(['success' => 'Image uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }
}
