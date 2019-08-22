<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\RequesterRepository::class, \App\Repositories\RequesterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FaseRepository::class, \App\Repositories\FaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FaseRepository::class, \App\Repositories\FaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FaseRepository::class, \App\Repositories\FaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdminRepository::class, \App\Repositories\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TipoSolicitanteRepository::class, \App\Repositories\TipoSolicitanteRepositoryEloquent::class);
        //:end-bindings:
    }
}
