<?php

namespace App\Policies;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostCommentPolicy
{

    public function create(User $user, PostComment $postComment): bool
    {
        return true;
    }

    public function delete(User $user, PostComment $postComment): Response
    {
        return $user->id === $postComment->user_id
        ? Response::allow()
        : Response::deny('forbidden access');
    }
}
