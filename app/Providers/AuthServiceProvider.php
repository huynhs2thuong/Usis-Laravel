<?php

namespace App\Providers;

use Auth;
use Cache;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Jollibee\Auth\CustomUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-user', function ($user) {
            return $user->is_admin;
        });

        Gate::define('edit-user', function ($user, $model) {
            return $user->is_admin || $user->id == $model->id;
        });

        Gate::define('delete-user', function ($user, $model) {
            return $user->is_admin && $user->id != $model->id;
        });

        Gate::define('ltm-admin-translations', function ($user) {
            return $user && $user->is_admin;
        });
        Gate::define('group-owner', function($customer, $gartId) {
            return $customer->id === Cache::get("gart.$gartId.owner");
        });

        Auth::provider('custom', function($app, array $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });


    }
}
