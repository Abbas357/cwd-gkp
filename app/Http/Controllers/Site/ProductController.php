<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('standardization_id', session('standardization_id'))->paginate(10);
        return view('site.standardizations.products.index', compact('products'));
    }

    public function create()
    {
        return view('site.standardizations.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'locality' => 'required',
            'location_type' => 'required',
            'ntn_number' => 'required|max:100',
            'sale_tax_number' => 'required|max:100',
            'specification_details' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->product_name;
        $product->locality = $request->locality;
        $product->location_type = $request->location_type;
        $product->ntn_number = $request->ntn_number;
        $product->sale_tax_number = $request->sale_tax_number;
        $product->specification_details = $request->specification_details;
        $product->standardization_id = session('standardization_id');

        $images = $request->file('product_images');

        if ($images) {
            foreach ($images as $image) {
                $product->addMedia($image)->toMediaCollection('product_images');
            }
        }
 
        if ($product->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the product.']);
    }

    public function show($id)
    {
        $product = Product::with('media')->findOrFail($id);
        $images = $product->getMedia('product_images');
        return view('site.standardizations.products.show', compact('product', 'images'));
    }
}