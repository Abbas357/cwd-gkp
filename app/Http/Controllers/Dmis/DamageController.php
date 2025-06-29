<?php

namespace App\Http\Controllers\dmis;

use App\Models\Damage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDamageRequest;

class DamageController extends Controller
{
    public function index(Request $request)
    {
        $damage = Damage::query();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            $userIds = $user->getSubordinates()->pluck('id')->toArray();
            $userIds[] = Auth::id();

            $damage->whereHas('posting.user', function ($query) use ($userIds) {
                $query->whereIn('id', $userIds);
            });
        }

        if ($request->ajax()) {
            $dataTable = Datatables::of($damage)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.dmis.damages.partials.buttons', compact('row'))->render();
                })
                ->addColumn('name', function ($row) {
                    return $row?->infrastructure?->name ?? 'No Infrastructure';
                })
                ->addColumn('office', function ($row) {
                    return $row?->posting?->office?->name ?? 'No Office';
                })
                ->addColumn('district', function ($row) {
                    return $row->damagedDistrict->name;
                })
                ->editColumn('report_date', function ($row) {
                    return $row->report_date->format('j, F Y');
                })
                ->editColumn('damage_nature', function ($row) {
                    return implode(', ', json_decode($row->damage_nature)) ?? 'No Damage Nature';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.dmis.damages.index');
    }

    public function create()
    {
        $cat = [
            'districts' => request()->user()->districts()->count() > 0
                ? request()->user()->districts()
                : \App\Models\District::all(),
            'infrastructure_type' => ['Road', 'Bridge', 'Culvert'],
            'road_status' => ['Partially restored', 'Fully restored', 'Not restored'],
            'damage_status' => ['Partially Damaged', 'Fully Damaged'],
        ];

        $html =  view('modules.dmis.damages.partials.create', compact('cat'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreDamageRequest $request)
    {
        $inputs = [
            'report_date',
            'type',
            'infrastructure_id',
            'damaged_length',
            'damage_east_start',
            'damage_north_start',
            'damage_east_end',
            'damage_north_end',
            'damage_status',
            'approximate_restoration_cost',
            'approximate_rehabilitation_cost',
            'road_status',
            'remarks',
        ];

        $damage = new Damage();
        foreach ($inputs as $input) {
            $damage->$input = $request->$input;
        }
        $damage->activity = setting('activity', 'dmis');
        $damage->session = setting('session', 'dmis');
        $damage->damage_nature = json_encode($request->damage_nature);
        $damage->posting_id = Auth::user()->currentPosting->id;

        $userDistricts = request()->user()->districts();

        if ($request->filled('district_id')) {
            $damage->district_id = $request->district_id;
        } else {
            if ($userDistricts->count() === 1) {
                $damage->district_id = $userDistricts->first()->id;
            } else {
                return response()->json(['error' => 'Please select a district']);
            }
        }

        if ($damage->save()) {
            $this->handleFileUploads($damage, $request);
            return response()->json(['success' => 'Damage added successfully']);
        } else {
            return response()->json(['error' => 'There is an error adding the damage']);
        }
    }

    private function handleFileUploads($damage, $request)
    {
        $fileCollections = [
            'damage_before_images' => 'damage_before_images',
            'damage_after_images' => 'damage_after_images',
        ];

        foreach ($fileCollections as $requestField => $collection) {
            if ($request->hasFile($requestField)) {
                $files = $request->file($requestField);
                foreach ($files as $document) {
                    try {
                        $damage->addMedia($document)
                            ->usingName($document->getClientOriginalName())
                            ->toMediaCollection($collection);
                    } catch (\Exception $e) {
                        Log::error("Failed to upload file: " . $document->getClientOriginalName() . " - " . $e->getMessage());
                    }
                }
            }
        }
    }

    public function show(Damage $damage)
    {
        return response()->json($damage);
    }

    public function showDetail(Damage $damage)
    {
        if (!$damage) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Damage Detail',
                ],
            ]);
        }

        $html = view('modules.dmis.damages.partials.detail', compact('damage'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showLogs(Damage $damage)
    {
        if (!$damage) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Damage Logs',
                ],
            ]);
        }

        $html = view('modules.dmis.damages.partials.logs', compact('damage'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Damage $damage)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $damage->{$request->field} = $request->value;

        if ($damage->isDirty($request->field)) {
            $damage->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }
        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(Damage $damage)
    {
        if ($damage->delete()) {
            return response()->json(['success' => 'Damage has been deleted successfully.']);
        }
        return response()->json(['error' => 'Error deleting damage.']);
    }
}
