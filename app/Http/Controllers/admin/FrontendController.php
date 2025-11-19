<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NavIcon;

class FrontendController extends Controller
{
    public function naviconPage()
    {
        $nav = NavIcon::first(); // Only one row
        return view('dashboard.front.navicon.edit', compact('nav'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'footer_description' => 'required',
            'footer_address' => 'required',
            'footer_email' => 'required|email',
        ]);

        $nav = NavIcon::first() ?? new NavIcon();

        // image upload
        if ($request->hasFile('icon')) {
            $imageName = time().'.'.$request->icon->extension();
            $request->icon->storeAs('public/nav_icons', $imageName);
            $nav->icon = 'nav_icons/'.$imageName;
        }

        $nav->phone = $request->phone;
        $nav->footer_description = $request->footer_description;
        $nav->footer_address = $request->footer_address;
        $nav->footer_email = $request->footer_email;

        $nav->save();

        return back()->with('message', 'Nav icon updated successfully!');
    }

}
