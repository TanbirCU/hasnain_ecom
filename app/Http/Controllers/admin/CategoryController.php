<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Category::all();
        return view('dashboard.category.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.category.add');
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
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|in:1,0',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('assets/admin/project/category_image');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            $file->move($path, $filename);
            $category->category_image = 'assets/admin/project/category_image/' . $filename;
            $category->save();
        }

        return response()->json(['message' => 'Category created successfully.'], 201);
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
        $data['category'] = Category::findOrFail($id);
        return view('dashboard.category.edit', $data);
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
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'status' => 'required|in:1,0',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status;

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('assets/admin/project/category_image');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            if (!empty($category->category_image) && File::exists(public_path($category->category_image))) {
                File::delete(public_path($category->category_image));
            }

            $file->move($uploadPath, $filename);
            $category->category_image = 'assets/admin/project/category_image/' . $filename;
        }

        $category->save();

        return response()->json(['message' => 'Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if (!empty($category->category_image) && File::exists(public_path($category->category_image))) {
            File::delete(public_path($category->category_image));
        }
        $category->delete();
        return redirect()->route('admin.category.index')->with('message','Category deleted successfully.');
    }
}
