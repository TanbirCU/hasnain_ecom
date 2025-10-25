<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sub_categories'] = SubCategory::with('category')->get();
        return view('dashboard.sub_category.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::where('status', 1)->get();
        return view('dashboard.sub_category.add',$data);
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
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:0,1',
        ]);

        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => 1,
        ]);

        return response()->json(['message' => 'Sub Category added successfully!'], 200);
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
        $data['sub_category'] = SubCategory::findOrFail($id);
        $data['categories'] = Category::where('status', 1)->get();
        return view('dashboard.sub_category.edit',$data);
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
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:0,1',
        ]);

        $sub_category = SubCategory::findOrFail($id);
        $sub_category->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Sub Category updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->delete();

        return redirect()->route('admin.sub_category.index')->with('message','Sub Category deleted successfully.');
    }
}
