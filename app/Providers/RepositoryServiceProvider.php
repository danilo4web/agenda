<?php

namespace App\Providers;

use App\Repositories\Contracts\{AgendaRepositoryInterface, UsuarioRepositoryInterface};
use App\Repositories\Eloquent\{AgendaRepository, UsuarioRepository};
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
        $this->app->bind(AgendaRepositoryInterface::class, AgendaRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
