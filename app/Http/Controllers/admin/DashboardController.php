<?php

namespace App\Http\Controllers\admin;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard.dashboard');
    }

    public function userList()
    {
        $data['users'] = User::all();
        return view('dashboard.user.user_list',$data);
    }

    public function approve(Request $request)
    {
        $user = User::find($request->id);
        $user->status = 1;
        $user->save();

        return response()->json(['message' => 'User Approved successfully.']);
    }
    public function adminLogin()
    {
        return view('dashboard.auth.admin_login');
    }
    public function adminLoginStore(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials) && auth()->user()->is_admin==1) {
            return redirect()->route('admin.dashboard')->with('message', 'Login successful.');
        } else {
            return redirect()->back()->withErrors(['Invalid credentials.']);
        }
    }

    public function adminLogout()
    {
        auth()->logout();
        return redirect()->route('admin_login');
    }
    public function orderList()
    {
        $data['orders'] = Order::orderBy('created_at', 'desc')->get();
        return view('dashboard.orders.order_list', $data);
    }
    public function orderDetails($order_id)
    {
        $data['order'] = Order::with('orderItems','orderItems.productDetails:id,product_code')->findOrFail($order_id);
        return view('dashboard.orders.order_details', $data);
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }


    public function downloadPDF($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        $pdf = PDF::loadView('dashboard.orders.pdf', compact('order'))
                ->setPaper('a4');

        return $pdf->download('order-'.$order->user_order_id.'.pdf');
    }


}
