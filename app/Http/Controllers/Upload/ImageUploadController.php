<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $path = $request->file('image')->store('images', 'public');
        $url = asset('storage/' . $path);
        return response()->json([
            'data' => 'ok',
            'url' => $url,
        ]);
    }
}
