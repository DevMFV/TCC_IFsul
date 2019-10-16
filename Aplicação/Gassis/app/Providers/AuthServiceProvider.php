<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Entities\User;
use App\Policies\UserPolicy;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    /**
    * Determine whether the user can create models.
    *
    * @param  \App\Entities\User  $user
    * @return mixed
    */

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('passwordStandart', function($user){
            if($user->password == '987654321'){
                return true;
            }
        });

        Gate::define('auth', function($user){
            if($user!=null){
                return true;
            }
        });

        Gate::define('admin', function($user){
            if($user->permission == 4){
                return true;
            }
        });

        Gate::define('requester', function($user){
            if($user->permission == 2){
                return true;
            }
        });

        Gate::define('admOrReq', function($user){
            if($user->permission == 4 || $user->permission == 2){
                return true;
            }
        });

        Gate::define('admReqProd', function($user){
            if($user->permission == 4 || $user->permission == 3 || $user->permission == 2){
                return true;
            }
        });

    }
}
