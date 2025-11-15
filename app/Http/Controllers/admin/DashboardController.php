<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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

}
