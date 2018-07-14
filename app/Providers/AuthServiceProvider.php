<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Task' => 'App\Policies\Company\TaskPolicy',
        'App\Models\Group' => 'App\Policies\Company\GroupPolicy',
        'App\Models\Site' => 'App\Policies\Company\SitePolicy',
        'App\Models\Post' => 'App\Policies\Company\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
