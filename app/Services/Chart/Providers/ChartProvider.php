<?php

namespace App\Services\Chart\Providers;

use App\Services\Chart\Repositories\ChartRepository;
use App\Services\Chart\Repositories\ChartRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ChartProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        match ($this->app->environment()) {
            default => $this->app->bind(ChartRepositoryInterface::class, function ($app, $parameters) {
                $model = $parameters['model'] ?? null;
                return new ChartRepository($model);
            }),
        };
    }
}
