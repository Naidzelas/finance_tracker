<?php

return [
    App\Providers\AppServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    App\Services\Etoro\Providers\EtoroProvider::class,
    App\Services\Tag\Providers\TagProvider::class,
    App\Services\Chart\Providers\ChartProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
];
