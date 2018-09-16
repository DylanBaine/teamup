<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use App\Models\Task;
use Auth;
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
        Task::observe(new \App\Observers\TaskObserver);
        Schema::defaultStringLength(191);
        if (Auth::user()) {
            $company = Company::find(Auth::user()->company_id);
        }

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
