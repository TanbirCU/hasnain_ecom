<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Unit;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::with(['category','subCategory'])->get()->sortByDesc('created_at');
        return view('dashboard.product.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::where('status', 1)->get();
        $data['sub_categories'] = SubCategory::where('status', 1)->get();
        $data['units'] = Unit::where('status', 1)->get();
        $data['sizes'] = Size::where('status', 1)->get();
        $data['colors'] = Color::where('status', 1)->get();
        return view('dashboard.product.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ✅ Validate
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'small_description' => 'nullable|string',
            'unit_id' => 'required|exists:units,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'images.*.*' => 'image|mimes:jpg,jpeg,png|max:5120' 
        ]);

        DB::beginTransaction();

        try {
            // ✅ 1. Save product
            $product = Product::create([
                'category_id'       => $request->category_id,
                'sub_category_id'   => $request->sub_category_id,
                'name'              => $request->name,
                'small_description' => $request->small_description,
                'unit_id'           => $request->unit_id,
                'stock'             => $request->stock,
                'min_order_quantity' => $request->min_order_quantity,
                'purchase_price'    => $request->purchase_price,
                'selling_price'     => $request->selling_price,
                'description'        => $request->description,
                'status'             => $request->status,
            ]);

            // ✅ 2. Save images
            if ($request->has('images')) {
                foreach ($request->images as $imageGroup) {
                    foreach ($imageGroup as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {

                            // Create folder if it doesn't exist
                            $destinationPath = public_path('assets/admin/project/product_image');
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true); // recursive creation
                            }

                            // Generate unique filename
                            $filename = time() . '_' . $image->getClientOriginalName();

                            // Move file to the custom folder
                            $image->move($destinationPath, $filename);

                            // Store relative path in DB
                            $imagePath = 'assets/admin/project/product_image/' . $filename;

                            ProductImage::create([
                                'product_id' => $product->id,
                                'image_path' => $imagePath,
                            ]);
                        }
                    }
                }
            }


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['product'] = Product::findOrFail($id);
        return view('dashboard.product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['product'] = Product::findOrFail($id);
        $data['categories'] = Category::all();
        $data['sub_categories'] = SubCategory::all();
        return view('dashboard.product.edit', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('message', 'Product deleted successfully.');
    }
}
