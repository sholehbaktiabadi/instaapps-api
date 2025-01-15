<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{

    use AuthorizesRequests;

    public function store(Request $request)
    {   
        $data = $request->validate([
            'content' => 'required|min:1|max:255',
            'post_id' => 'required',
        ]);
        try {
            $data['user_id'] = auth()->user()->id;
            PostComment::create($data);
            return response()->json(['data' => 'ok']);
        } catch (Exception $err) {
            return response()->json(['data' => $err], 500);
        }
    }

    public function destroy(string $id)
    {
        $post = PostComment::find($id);
        if($post == null){
            return response()->json(['data' => 'comment is not exist'], 400);
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
