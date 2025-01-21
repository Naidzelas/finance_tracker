<?php 
namespace App\Services\Etoro\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Etoro\Repositories\EtoroRepository;
use App\Services\Etoro\Repositories\EtoroInterface;

class EtoroProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        match ($this->app->environment()) {
            default => $this->app->bind(EtoroInterface::class, EtoroRepository::class),
        };
    }
}