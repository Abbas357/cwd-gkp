<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Standardization;

class ProductController extends Controller
{
    public function detail(Standardization $Standardization)
    {
        $products = $Standardization->products()->get();
        if (!$products) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Products detail',
                ],
            ]);
        }
        $html = view('admin.standardizations.partials.products', compact('products'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $product->{$validatedData['field']} = $validatedData['value'];

            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Resource updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product'
            ], 500);
        }
    }

    public function upload(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        
        try {
            $media = $product->addMedia($request->file('file'))->toMediaCollection('product_images');
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'fileUrl' => $media->getUrl()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->delete()) {
            return response()->json(['success' => 'Product deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete Product'], 500);
    }
}
