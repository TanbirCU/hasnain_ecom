<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductShowController extends Controller
{
    public function product_details($product_id)
    {
        try {
            $productId = decrypt($product_id);
        } catch (\Exception $e) {
            abort(404); // if someone tampers with the URL
        }

        $product = Product::with(['images', 'colors', 'sizes'])->find($productId);

        if (!$product) {
            abort(404);
        }

        return view('front.product.details', compact('product'));
    }
}
