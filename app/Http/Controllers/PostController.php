<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{   
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with('comments')->latest()->get();

        return response()->json(['data' => $posts->append('likes_count')]);
    }

    public function store(Request $request)
    {   
        $data = $request->validate([
            'caption' => 'required|min:3|max:255',
            'image_url' => 'required|min:3|max:255',
        ]);
        try {
            $data['user_id'] = auth()->user()->id;
            $this->authorize('create', $data);
            Post::create($data);
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }

    public function show(string $id)
    {
        $post = Post::with('comments')->find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        $this->authorize('view', $post);
        return response()->json(['data' => $post->append('likes_count')]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'caption' => 'required|min:3|max:255',
            'image_url' => 'min:3|max:255',
        ]);
        $post = Post::find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        $this->authorize('update', $post);
        try {
            $post->update($data);
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        $this->authorize('delete', $post);
        try {
            $post->delete();
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }
}
