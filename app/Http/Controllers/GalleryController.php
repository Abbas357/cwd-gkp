<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreGalleryRequest;

use Illuminate\Support\Str;

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
                    return $row->user ? $row->user->name . ' (' . $row->user->designation . ' - ' . $row->user->office  . ')' : 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.gallery.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => Gallery::withoutGlobalScope('published')->count(),
            'publishedCount' => Gallery::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => Gallery::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => Gallery::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'gallery_type' => Category::where('type', 'gallery_type')->get(),
        ];
        return view('admin.gallery.create', compact('stats', 'cat'));
    }

    public function store(StoreGalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $title = collect(explode(' ', $request->title))->take(5)->join(' ');
        $gallery->slug = Str::slug($title) . '-' . substr(uniqid(), -6) . '-' . date('d-m-Y');
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
            return redirect()->route('admin.gallery.create')->with('success', 'Gallery added successfully');
        }

        return redirect()->route('admin.gallery.create')->with('error', 'There was an error adding your Gallery');
    }

    public function show(Gallery $Gallery)
    {
        return response()->json($Gallery);
    }

    public function publishGallery(Request $request, $galleryId)
    {
        $gallery = Gallery::withoutGlobalScope('published')->findOrFail($galleryId);
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

    public function showDetail($galleryId)
    {
        $gallery = Gallery::withoutGlobalScope('published')->findOrFail($galleryId);
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

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $gallery = Gallery::withoutGlobalScope('published')->findOrFail($request->id);

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


    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg,gif|max:10240',
        ]);

        $gallery = Gallery::withoutGlobalScope('published')->findOrFail($request->id);

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


    public function destroy($galleryId)
    {
        $gallery = Gallery::withoutGlobalScope('published')->findOrFail($galleryId);
        if ($gallery->status === 'draft' && is_null($gallery->published_at)) {
            if ($gallery->delete()) {
                return response()->json(['success' => 'Gallery has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft gallery that were once published cannot be deleted.']);
    }
}
