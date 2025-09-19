<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\{
    AtractivoRepositoryInterface,
    CategoriaRepositoryInterface,
    ContactoRepositoryInterface,
    FuenteRepositoryInterface,
    ImagenRepositoryInterface,
    TagRepositoryInterface,
    UserRepositoryInterface
};
use App\Repositories\Eloquent\{
    AtractivoRepository,
    CategoriaRepository,
    ContactoRepository,
    FuenteRepository,
    ImagenRepository,
    TagRepository,
    UserRepository
};
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository bindings
        $this->app->bind(AtractivoRepositoryInterface::class, AtractivoRepository::class);
        $this->app->bind(CategoriaRepositoryInterface::class, CategoriaRepository::class);
        $this->app->bind(ContactoRepositoryInterface::class, ContactoRepository::class);
        $this->app->bind(FuenteRepositoryInterface::class, FuenteRepository::class);
        $this->app->bind(ImagenRepositoryInterface::class, ImagenRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
