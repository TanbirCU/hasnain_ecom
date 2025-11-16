<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function home()
    {
        $data['categories'] = Category::where('status',1)->limit(12)->get();
        $data['products'] = Product::whereHas('images')
        ->with('images')
        ->where('status', 1)
        ->orderBy('id', 'asc')
        ->limit(8)
        ->get(['id', 'name', 'selling_price', 'small_description']);


        return view('front.home.home',$data);

    }
    public function contact()
    {
        return view('front.contact.contact');

    }

    public function userRegistration()
    {
        return view('front.user.registration');

    }

    public function userRegistrationStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone'=> 'required|string|max:15',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user (assuming you have a User model)
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email ?? '';
        $user->password = bcrypt($request->password);
        $user->trade_license_no = $request->trade_license_no ?? '';
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->nid = $request->nid ?? '';
        $user->reference_no = $request->reference_no ?? '';
        $user->status = 0;

        if ($request->hasFile('trade_license_image')) {
            $file = $request->file('trade_license_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('assets/front/user/trade_license_image');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            if (!empty($category->trade_license_image) && File::exists(public_path($category->trade_license_image))) {
                File::delete(public_path($category->trade_license_image));
            }

            $file->move($uploadPath, $filename);
            $user->trade_license_image = 'assets/front/user/trade_license_image/' . $filename;
        }
        if ($request->hasFile('shop_image')) {
            $file = $request->file('shop_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('assets/front/user/shop_image');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            if (!empty($category->shop_image) && File::exists(public_path($category->shop_image))) {
                File::delete(public_path($category->shop_image));
            }

            $file->move($uploadPath, $filename);
            $user->shop_image = 'assets/front/user/shop_image/' . $filename;
        }

        $user->save();
        Auth::login($user);
        return response()->json([
            'message' => 'Registration successful! You can now log in.',
        ]);
    }
    public function userLogin()
    {
        return view('front.user.login');

    }
    public function userLoginStore(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);
        $login_id = $request->input('login_id');
        $password = $request->input('password');

        $fieldType = filter_var($login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (auth()->attempt([$fieldType => $login_id, 'password' => $password])) {

            if (auth()->user()->status != 1) {
                auth()->logout();
                return redirect()->route('user_login')
                    ->with('error', 'Your account is not approved yet.');
            }

            return redirect()->intended(route('home'))->with('success', 'Login successful!');
        }
        return back()->with('error', 'Invalid login credentials.');
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
