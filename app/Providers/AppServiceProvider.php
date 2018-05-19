<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(new \App\Observers\UserObserver);
        Post::observe(new \App\Observers\PostObserver);
        Schema::defaultStringLength(191);
        View::share('allTypes', Type::get());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
