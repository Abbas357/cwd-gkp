<?php

namespace App\Http\Controllers\ServiceCard;

use App\Http\Controllers\Controller;

use App\Models\Card;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', null);
        // dd($type);
        $cards = Card::query()->latest('id');

        $cards->when($type !== null, function ($query) use ($type) {
            $query->where('cardable_type', $type);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($cards)
                ->addColumn('type', function ($row) {
                    return class_basename($row->cardable_type);
                })
                ->editColumn('status', function ($row) {
                    return view('modules.cards.partials.status', compact('row'))->render();
                })
                ->addColumn('view', function ($row) {
                    return view('modules.cards.partials.view', compact('row'))->render();
                })
                ->editColumn('issue_date', function ($row) {
                    return $row->issue_date->format('j, F Y');
                })
                ->editColumn('expiry_date', function ($row) {
                    return $row->expiry_date->diffForHumans();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['status', 'view']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.cards.index');
    }

    public function view($id)
    {
        $card = Card::findOrFail($id);
        $cardType = $card->cardable_type::findOrFail($card->cardable_id);
        $data = null;
        if(basename($card->cardable_type) == 'ServiceCard') {
        } elseif (basename($card->cardable_type) == 'ContractorRegistration'){ 
        } elseif (basename($card->cardable_type) == 'Standardization'){ 
        }


        $html = view('modules.cards.partials.cards', compact('card', 'qrCodeUri'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
}
