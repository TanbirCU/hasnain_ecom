<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['suppliers'] = Supplier::all()->sortByDesc('created_at');
        return view('dashboard.supplier.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.supplier.add');
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
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'required|string|unique:suppliers,phone',
            'address' => 'nullable|string|max:500',
        ]);
        $supplier = new Supplier();
        $supplier->name = $request->input('name');
        $supplier->contact_person = $request->input('contact_person');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->address = $request->input('address');
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with('message', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data['supplier'] = Supplier::findOrFail($id);
        // return view('dashboard.supplier.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['supplier'] = Supplier::findOrFail($id);
        return view('dashboard.supplier.edit', $data);
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

        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->input('name');
        $supplier->contact_person = $request->input('contact_person');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->address = $request->input('address');
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with('message', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.supplier.index')->with('message', 'Supplier deleted successfully.');
    }
}
