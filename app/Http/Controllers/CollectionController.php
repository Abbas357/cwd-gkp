<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $categories = $type ? Collection::where('type', $type)->get() : Collection::all();

        if ($request->ajax()) {
            return response()->json($categories);
        }

        return view('collections.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        $collection = Collection::create([
            'type' => $request->type,
            'name' => $request->name,
        ]);

        if ($collection) {
            return response()->json(['success' => 'Collection Created Successfully']);
        } else {
            return response()->json(['danger' => 'Error creating collection']);
        }

        return redirect()->route('collections.index');
    }

    public function destroy(Collection $collection)
    {
        if ($collection->delete()) {
            return response()->json(['success' => 'Collection has been deleted successfully.']);
        }

        return response()->json(['error' => 'Collection can\'t be deleted.']);
    }
}
