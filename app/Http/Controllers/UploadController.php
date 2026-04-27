<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //

    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $path = $file->store('uploads', 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'error' => 'No file uploaded'
        ], 400);
    }
}
