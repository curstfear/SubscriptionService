<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\AdminPolicy;


class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        User::class => AdminPolicy::class,
    ];

    /**
     * Register services.
     */

    public function register(): void
    {
        $this->registerPolicies();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
