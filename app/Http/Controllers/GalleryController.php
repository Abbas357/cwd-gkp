<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SiteNotification;

use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreGalleryRequest;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $galleries = Gallery::query()->withoutGlobalScope('published');

        $galleries->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($galleries)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.gallery.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.gallery.partials.status', compact('row'))->render();
                })
                ->addColumn('uploaded_by', function ($row) {
                    return $row->user?->position 
                    ? '<a href="'.route('admin.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'uploaded_by']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.gallery.index');
    }

    public function create()
    {
        $cat = [
            'gallery_type' => Category::where('type', 'gallery_type')->get(),
        ];
        $html = view('admin.gallery.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreGalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->slug = Str::uuid();
        $gallery->type = $request->type;
        $gallery->description = $request->description;
        $gallery->status = 'draft';

        $images = $request->file('images');

        if ($request->hasFile('cover_photo')) {
            $gallery->addMedia($request->file('cover_photo'))->toMediaCollection('gallery_covers');
        } elseif ($images && count($images) > 0) {
            $gallery->addMedia($images[0])->toMediaCollection('gallery_covers');
        }

        if ($images && count($images) > 0) {
            $gallery->items = count($images);
            foreach ($images as $image) {
                $gallery->addMedia($image)->toMediaCollection('gallery');
            }
        } else {
            $gallery->items = 0;
        }

        if ($request->user()->gallery()->save($gallery)) {
            return response()->json(['success' => 'Gallery added successfully'], 200);
        }

        return response()->json(['error' => 'There was an error adding your Gallery'], 500);
    }

    public function show(Gallery $Gallery)
    {
        return response()->json($Gallery);
    }

    public function publishGallery(Request $request, Gallery $gallery)
    {
        if ($gallery->status === 'draft') {
            $gallery->published_at = now();
            $gallery->status = 'published';
            $message = 'Gallery has been published successfully.';
        } else {
            $gallery->status = 'draft';
            $message = 'Gallery has been unpublished.';
        }
        $gallery->published_by = $request->user()->id;
        $gallery->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveGallery(Request $request, Gallery $gallery)
    {
        if (!is_null($gallery->published_at)) {
            $gallery->status = 'archived';
            $gallery->save();
            return response()->json(['success' => 'Gallery has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Gallery cannot be archived.'], 403);
    }

    public function showDetail(Gallery $gallery)
    {
        if (!$gallery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Gallery Detail',
                ],
            ]);
        }

        $cat = [
            'gallery_type' => Category::where('type', 'gallery_type')->get(),
        ];

        $html = view('admin.gallery.partials.detail', compact('gallery', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Gallery $gallery)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($gallery->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived gallery cannot be updated'], 403);
        }

        $gallery->{$request->field} = $request->value;

        if ($gallery->isDirty($request->field)) {
            $gallery->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Gallery $gallery)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:10240',
        ]);

        if (in_array($gallery->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived gallery cannot be updated'], 403);
        }

        try {
            $file = $request->file('file');
            $gallery->addMedia($file)->toMediaCollection('gallery');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Gallery $gallery)
    {
        if (request()->user()->isAdmin() || ($gallery->status === 'draft' && is_null($gallery->published_at))) {
            if ($gallery->delete()) {
                return response()->json(['success' => 'Gallery has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft gallery that were once published cannot be deleted.']);
    }

    public function updateComments(Request $request, Gallery $Gallery)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $Gallery->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
