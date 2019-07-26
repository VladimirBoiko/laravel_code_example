<?php

namespace App\Providers;

use App\Comment;
use App\ForumTopic;
use App\Observers\CommentObserver;
use App\Observers\ForumTopicPointsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe(CommentObserver::class);
        ForumTopic::observe(ForumTopicPointsObserver::class);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
}
