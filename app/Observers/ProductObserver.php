<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function updating($product) 
    {
        if ($product->isDirty('status')) {
            $product->status_updated_at = now();
            $product->status_updated_by = auth_user()->id ?? null;
        }
    }
}
