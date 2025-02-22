<?php

return [
    App\Providers\AppServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    App\Services\Etoro\Providers\EtoroProvider::class,
    App\Services\Tag\Providers\TagProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
];
