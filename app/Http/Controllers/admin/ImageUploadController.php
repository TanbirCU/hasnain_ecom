<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        // Check if file exists
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');

            return response()->json([
                'success' => true,
                'file_path' => asset('storage/' . $path),
                'file_name' => $filename
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    }
}
