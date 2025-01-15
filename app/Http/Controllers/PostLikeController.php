<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required',
        ]);
        try {
            $data['user_id'] = auth()->user()->id;
            PostLike::create($data);
            return response()->json(['data' => 'ok']);
        } catch (Exception $err) {
            return response()->json(['data' => $err], 500);
        }
    }

    public function destroy(string $id)
    {
        $postLike = PostLike::where('user_id', auth()->user()->id)
        ->where('post_id', $id)->first();
        try {
            $this->authorize('delete', $postLike);
            $postLike->delete();
            return response()->json(['data' => 'ok']);
        } catch (Exception) {
            return response()->json(['data' => 'failed'], 500);
        }
    }
}
