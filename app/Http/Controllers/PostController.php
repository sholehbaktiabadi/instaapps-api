<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json(['data' => $posts]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required|min:3|max:255',
            'imageUrl' => 'required|min:3|max:255',
        ]);
        try {
            Post::create($datas);
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        return response()->json(['data' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'caption' => 'required|min:3|max:255',
            'imageUrl' => 'min:3|max:255',
        ]);

        $post = Post::find($id);

        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }

        try {
            $post->update($data);
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        try {
            $post->delete();
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }
}
