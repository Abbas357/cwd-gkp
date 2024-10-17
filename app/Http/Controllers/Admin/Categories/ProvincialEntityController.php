<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;

use App\Models\Categories\ProvincialEntity;
use Illuminate\Http\Request;

class ProvincialEntityController extends Controller
{
    public function index()
    {
        $provincial_entities = ProvincialEntity::paginate(10);
        return view('admin.categories.provincial_entities.index', compact('provincial_entities'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        ProvincialEntity::create(['name' => $request->name]);
        return to_route('admin.provincial_entities.index')->with('success', 'Provincial Entity Created successfully.');
    }

    public function destroy(ProvincialEntity $provincial_entity)
    {
        $provincial_entity->delete();
        return back()->with('success', 'Provincial Entity deleted.');
    }
}
