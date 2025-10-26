<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SalesMan;
use Illuminate\Http\Request;

class SalesManController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sales_men'] = SalesMan::all()->sortByDesc('created_at');
        return view('dashboard.sales_man.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sales_man.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:sales_men,email',
            'phone' => 'required|string|unique:sales_men,phone',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);
        $salesMan = new SalesMan();
        $salesMan->name = $request->input('name');
        $salesMan->email = $request->input('email');
        $salesMan->phone = $request->input('phone');
        $salesMan->area = $request->input('area');
        $salesMan->address = $request->input('address');
        $salesMan->save();  
        return response()->json([
            'message' => 'Sales Man created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['sales_man'] = SalesMan::findOrFail($id);
        return view('dashboard.sales_man.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:sales_men,email,'.$id,
            'phone' => 'required|string|unique:sales_men,phone,'.$id,
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500', 
        ]);
        $salesMan = SalesMan::findOrFail($id);
        $salesMan->name = $request->input('name');
        $salesMan->email = $request->input('email');
        $salesMan->phone = $request->input('phone');
        $salesMan->area = $request->input('area');
        $salesMan->address = $request->input('address');
        $salesMan->save();
        return response()->json([
            'message' => 'Sales Man updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salesMan = SalesMan::findOrFail($id);
        $salesMan->delete();
        return redirect()->route('admin.sales_man.index')->with('message', 'Sales Man deleted successfully.');
    }
}
