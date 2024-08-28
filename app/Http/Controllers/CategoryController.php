<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $categories = $type ? Category::where('type', $type)->get() : Category::all();

        if ($request->ajax()) {
            return response()->json($categories);
        }

        return view('categories.collections.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        $category = Category::create([
            'type' => $request->type,
            'name' => $request->name,
        ]);

        if ($category) {
            return response()->json(['success' => 'Collection Created Successfully']);
        } else {
            return response()->json(['danger' => 'Error creating collection']);
        }

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return response()->json(['success' => 'Collection has been deleted successfully.']);
        }

        return response()->json(['error' => 'Collection can\'t be deleted.']);
    }
}
