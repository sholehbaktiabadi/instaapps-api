<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Policies\PostCommentPolicy;
use App\Policies\PostLikePolicy;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(PostLike::class, PostLikePolicy::class);
        Gate::policy(PostComment::class, PostCommentPolicy::class);
    }
}
