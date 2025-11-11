<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\File;
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
            'color_id'=> 'nullable|array',
            'color_id.*' => 'exists:colors,id',
            'size_id'=> 'nullable|array',
            'size_id.*' => 'exists:sizes,id',
            'images' => 'nullable|array',
            'images.*.*' => 'image|mimes:jpg,jpeg,png|max:5120'
        ]);

        DB::beginTransaction();

        try {

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
            if ($request->has('color_id')) {
                $product->colors()->sync($request->color_id);
            }
            // Save multiple sizes
            if ($request->has('size_id')) {
                $product->sizes()->sync($request->size_id);
            }

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
        $product = Product::with(['category', 'subCategory', 'unit', 'colors', 'sizes', 'images'])->findOrFail($id);
        return view('dashboard.product.show_modal', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['product'] = Product::with(['colors', 'sizes', 'images'])->findOrFail($id);
        $data['categories'] = Category::where('status', 1)->get();
        $data['sub_categories'] = SubCategory::where('status', 1)->get();
        $data['units']= Unit::where('status', 1)->get();
        $data['colors'] = Color::where('status', 1)->get();
        $data['sizes']= Size::where('status', 1)->get();
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
            'color_id' => 'nullable|array',
            'color_id.*' => 'exists:colors,id',
            'size_id' => 'nullable|array',
            'size_id.*' => 'exists:sizes,id',
            'images' => 'nullable|array',
            'images.*.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'deleted_images' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            // Update product details
            $product->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'name' => $request->name,
                'small_description' => $request->small_description,
                'unit_id' => $request->unit_id,
                'stock' => $request->stock,
                'min_order_quantity' => $request->min_order_quantity,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // Sync colors
            if ($request->has('color_id')) {
                $product->colors()->sync($request->color_id);
            } else {
                $product->colors()->detach();
            }

            // Sync sizes
            if ($request->has('size_id')) {
                $product->sizes()->sync($request->size_id);
            } else {
                $product->sizes()->detach();
            }

            // Handle deleted images
            if ($request->filled('deleted_images')) {
                $deletedImageIds = explode(',', $request->deleted_images);
                foreach ($deletedImageIds as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        // Delete physical file
                        if (File::exists(public_path($image->image_path))) {
                            File::delete(public_path($image->image_path));
                        }
                        // Delete database record
                        $image->delete();
                    }
                }
            }

            // Handle new images upload
            if ($request->has('images')) {
                foreach ($request->images as $imageGroup) {
                    foreach ($imageGroup as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            // Create folder if it doesn't exist
                            $destinationPath = public_path('assets/admin/project/product_image');
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }

                            // Generate unique filename
                            $filename = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();

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
                'message' => 'Product updated successfully!'
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = Product::with(['colors', 'sizes', 'images'])->findOrFail($id);

            // 1. Detach pivot table relations
            $product->colors()->detach();
            $product->sizes()->detach();

            // 2. Delete associated images from storage and database
            foreach ($product->images as $image) {
                $imagePath = public_path($image->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // delete file
                }
                $image->delete(); // delete DB record
            }

            // 3. Delete the product
            $product->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

}
