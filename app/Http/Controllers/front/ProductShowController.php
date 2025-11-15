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

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if (!isset($cart[$id])) {
            $cart[$id] = [
                "product_id" => $id,
                "qty" => $request->qty,
                "size_id" => $request->size_id,
                "color_id" => $request->color_id,
            ];
        } else {
            $cart[$id]['qty'] += $request->qty;
        }

        session()->put('cart', $cart);

        // Build cart details with product names (with ID as key)
        $items = [];
        foreach ($cart as $cartId => $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $items[$cartId] = [
                'name' => $product->name,
                'qty'  => $item['qty'],
            ];
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Product added to cart successfully!',
            'cart_count'  => count($cart),
            'cart_items'  => $items // Changed to match updateCartDropdown format
        ]);
    }

  public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // Build cart details
        $items = [];
        foreach ($cart as $cartId => $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $items[$cartId] = [
                    'name' => $product->name,
                    'qty'  => $item['qty'],
                ];
            }
        }

        return response()->json([
            'success' => true,
            'cart_items' => $items,
            'cart_count' => count($cart),
            'message' => 'Item removed from cart'
        ]);
    }

    public function cartView()
    {
        $cart = session()->get('cart', []);
        return view('front.cart.cart', compact('cart'));
    }




    public function shop(Request $request)
    {
         $data['products'] = Product::whereHas('images')
        ->with('images')
        ->where('status', 1)
        ->orderBy('id', 'asc')
        ->limit(8)
        ->get(['id', 'name', 'selling_price', 'small_description']);

        return view('front.product.shop',$data);
    }
}
