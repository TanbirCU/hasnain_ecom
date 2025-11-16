<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

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

    public function checkout(Request $request)
    {
        // Get cart items from request
        $cartItems = json_decode($request->cart_items, true);
        $grandTotal = $request->grand_total;

        // Validate
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        return view('front.checkout.checkout', compact('cartItems', 'grandTotal'));
    }

    // In ProductShowController
    public function placeOrder(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'district' => 'required|string',
            'upzilla' => 'required|string',
            'union' => 'required|string',
            'extra_address' => 'required|string',
        ]);

        // // Get cart items
        $cartItems = json_decode($request->cart_items, true);
        $grandTotal = $request->grand_total;

        // // Create order (adjust according to your Order model)
        $order = new Order();
        $order->name = $request->name;
        $order->user_id = auth()->id();
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->district = $request->district;
        $order->upzilla = $request->upzilla;
        $order->union = $request->union;
        $order->extra_address = $request->extra_address;
        $order->grand_total = $grandTotal;
        $order->status = 0; // pending
        $order->save();
        $order->user_order_id = 'ORD'.str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $order->save();
        // // Save order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

        // // Clear cart from session if you're using it
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'redirect_url' => route('order.success', $order->id)
        ]);
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
