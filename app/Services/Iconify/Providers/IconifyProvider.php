<?php 
namespace App\Services\Iconify\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Iconify\Repositories\IconifyRepository;
use App\Services\Iconify\Repositories\IconifyRepositoryInterface;

class IconifyProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        match ($this->app->environment()) {
            default => $this->app->bind(IconifyRepositoryInterface::class, IconifyRepository::class),
        };
    }
}
