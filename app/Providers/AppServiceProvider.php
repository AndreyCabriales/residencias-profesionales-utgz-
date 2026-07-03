<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Repositories\DocumentoRepository;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use App\Repositories\AlumnoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentoRepositoryInterface::class, DocumentoRepository::class);
        $this->app->bind(AlumnoRepositoryInterface::class, AlumnoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
