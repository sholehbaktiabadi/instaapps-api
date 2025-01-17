<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{   
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::latest()->get();

        return response()->json(['data' => $posts]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required|min:3|max:255',
            'image_url' => 'required|min:3|max:255',
        ]);
        try {
            $data['user_id'] = auth()->user()->id;
            $post = new Post($data);
            $this->authorize('create', $post);
            $post->save();
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }

    public function show(string $id)
    {
        $post = Post::with(['comments.user','user'])->find($id);
        if($post == null){
            return response()->json(['data' => 'post is not exist'], 400);
        }
        $amilike = PostLike::where('user_id', auth()->id())
        ->where('post_id', $id)
        ->exists();
        $this->authorize('view', $post);
        $post->append('likes_count');
        $post->setAttribute('amilike', $amilike);
        return response()->json(['data' => $post]);
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
