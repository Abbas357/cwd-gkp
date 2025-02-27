<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $categories = Category::when($type, function ($query, $type) {
            return $query->where('type', $type);
        })->paginate(100);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create(['name' => $request->name, 'type' => $request->type]);
        return to_route('admin.categories.index')->with('success', 'Category created.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
