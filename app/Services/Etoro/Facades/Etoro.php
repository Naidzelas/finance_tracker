<?php 
namespace App\Services\Etoro\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Etoro\Repositories\EtoroRepository;

/**
 * @see \App\Services\Weather\Repositories\WeatherRepository
 */
class Etoro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EtoroRepository::class;
    }
}