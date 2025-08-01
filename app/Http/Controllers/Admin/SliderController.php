<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;

use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreSliderRequest;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $sliders = Slider::query()->withoutGlobalScope('published');

        $sliders->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        }); 

        $relationMappings = [
            'user' => 'user.currentPosting.designation.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($sliders)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.sliders.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.sliders.partials.status', compact('row'))->render();
                })
                ->addColumn('image', function ($row) {
                    return '<a target="_blank" href="' . $row->getFirstMediaUrl('sliders') . '" class="btn btn-light bi bi-image fs-4"></span>';
                })
                ->addColumn('user', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'image', 'user']);

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request, 
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.sliders.index');
    }

    public function create()
    { 
        $html = view('admin.sliders.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreSliderRequest $request)
    {
        $slider = new Slider();
        $slider->title = $request->title;
        $slider->slug = $this->slug($request->title);
        $slider->summary = $request->summary;
        $slider->description = $request->description;
        $slider->status = 'draft';

        if ($request->hasFile('image')) {
            $slider->addMedia($request->file('image'))
                ->toMediaCollection('sliders');
        }

        Cache::forget('sliders');

        if ($request->user()->sliders()->save($slider)) {
            return response()->json(['success' => 'Slider Added successfully']);
        }
        return response()->json(['danger' => 'There is an error adding the slider']);
    }

    public function show(Slider $slider)
    {
        return response()->json($slider);
    }

    public function publishSlider(Request $request, Slider $slider)
    {
        $publishedSlidersCount = Slider::where('status', 'published')->whereNotNull('published_at')->count();

        if ($slider->status === 'draft') {
            if ($publishedSlidersCount >= 5) {
                return response()->json(['error' => 'You cannot publish more than 5 sliders.'], 400);
            }
            $slider->published_at = now();
            $slider->status = 'published';
            $message = 'Slider has been published successfully.';
        } else {
            $slider->status = 'draft';
            $message = 'Slider has been unpublished.';
        }
        Cache::forget('sliders');
        $slider->published_by = $request->user()->id;
        $slider->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveSlider(Request $request, Slider $slider)
    {
        if (!is_null($slider->published_at)) {
            $slider->status = 'archived';
            $slider->save();
            return response()->json(['success' => 'Slider has been archived successfully.'], 200);
        }
        Cache::forget('sliders');
        return response()->json(['error' => 'Slider cannot be archived.'], 403);
    }

    public function showDetail(Slider $slider)
    {
        if (!$slider) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Slider Detail',
                ],
            ]);
        }

        $html = view('admin.sliders.partials.detail', compact('slider'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Slider $slider)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($slider->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived sliders cannot be updated'], 403);
        }

        $slider->{$request->field} = $request->value;

        if ($slider->isDirty($request->field)) {
            $slider->save();
            Cache::forget('sliders');
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10240', 
        ]);

        if (in_array($slider->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived sliders cannot be updated'], 403); 
        }

        try {
            $slider->addMedia($request->file('image'))
                ->toMediaCollection('sliders');
            Cache::forget('sliders');
            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Slider $slider)
    {
        if ((auth_user()->isAdmin() || ($slider->status === 'draft' && is_null($slider->published_at))) && $slider->delete()) {
            Cache::forget('sliders');
            return response()->json(['success' => 'Slider has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft sliders that were once published cannot be deleted.']);
    }

    public function updateComments(Request $request, Slider $Slider)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $Slider->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
