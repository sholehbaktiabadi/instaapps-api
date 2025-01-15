<?php

namespace App\Policies;

use App\Models\PostLike;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostLikePolicy
{

    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, PostLike $postLike): Response
    {
        return $user->id === $postLike->user_id
        ? Response::allow()
        : Response::deny('forbidden access');
    }

}