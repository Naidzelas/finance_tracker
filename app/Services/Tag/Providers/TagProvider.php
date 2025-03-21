<?php

namespace App\Services\Tag\Providers;

use App\Services\Tag\Repositories\TagRepository;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class TagProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        match ($this->app->environment()) {
            default => $this->app->bind(TagRepositoryInterface::class, function ($app, $parameters) {
                $model = $parameters['model'] ?? null;
                $availableTags = $parameters['availableTags'] ?? null;
                return new TagRepository($model, $availableTags);
            }),
            // default => $this->app->bind(TagRepositoryInterface::class, TagRepository::class),
        };
    }
}
