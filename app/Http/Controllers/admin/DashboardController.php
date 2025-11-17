<?php

namespace App\Http\Controllers\admin;

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
}
