<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        Passport::routes();

        Gate::define('superAdmin', function($user){
            return $user->role == '1';
        });
        Gate::define('activeAdmin', function($user){
            return $user->role == '2';
        });
        Gate::define('inactiveAdmin', function($user){
            return $user->role == '3';
        });
        Gate::define('activeManager', function($user){
            return $user->role == '4';
        });
        Gate::define('inactiveManager', function($user){
            return $user->role == '5';
        });
        Gate::define('activeAccounts', function($user){
            return $user->role == '6';
        });
        Gate::define('inactiveAccounts', function($user){
            return $user->role == '7';
        });
        Gate::define('activeAgent', function($user){
            return $user->role == '8';
        });
        Gate::define('inactiveAgent', function($user){
            return $user->role == '9';
        });
        Gate::define('activeRider', function($user){
            return $user->role == '10';
        });
        Gate::define('inactiveRider', function($user){
            return $user->role == '11';
        });
        Gate::define('activeMerchant', function($user){
            return $user->role == '12';
        });
        Gate::define('inactiveMerchant', function($user){
            return $user->role == '13';
        });
        Gate::define('activeEmployee', function($user){
            return $user->role == '14';
        });
        Gate::define('inactiveEmployee', function($user){
            return $user->role == '15';
        });
        Gate::define('activeCallCenter', function($user){
            return $user->role == '16';
        });
        Gate::define('inactiveCallCenter', function($user){
            return $user->role == '17';
        });
        Gate::define('ActiveInCharge', function($user){
            return $user->role == '18';
        });
    }
}
