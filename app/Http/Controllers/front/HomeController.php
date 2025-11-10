<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('front.home.home');

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user (assuming you have a User model)
        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Redirect to a desired location with a success message
        return redirect()->route('home')->with('success', 'Registration successful! You can now log in.');
    }
    public function userLogin()
    {
        return view('front.user.login');

    }
    public function userLoginStore(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'login_id' => 'required',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (auth()->attempt(['email' => $credentials['login_id'], 'password' => $credentials['password']]) || auth()->attempt(['mobile' => $credentials['login_id'], 'password' => $credentials['password']])) {
            // Authentication passed...
            return redirect()->intended(route('home'))->with('success', 'Login successful!');
        }

        // Authentication failed...
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
}
