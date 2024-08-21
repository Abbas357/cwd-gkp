<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $categories  = Collection::simplePaginate(10);
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
            session()->flash('success', 'Collection Created Successfully');
        } else {
            session()->flash('danger', 'Error creating collection');
        }

        return redirect()->route('collections.index');
    }

    public function destroy(Collection $collection)
    {
        if ($collection && $collection->delete()) {
            session()->flash('success', 'Collection deleted successfully');
        } else {
            session()->flash('danger', 'Uh Oh! Collection cannot be deleted.');
        }

        return redirect()->route('collections.index');
    }
}
