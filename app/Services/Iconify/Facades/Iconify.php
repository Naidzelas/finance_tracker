<?php 
namespace App\Services\Iconify\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Iconify\Repositories\IconifyRepository;

/**
 * @method static \App\Services\Iconify\DTOs\IconSearchResultData searchIcons(string $keyword)
 * 
 * @see \App\Services\Iconify\Repositories\IconifyRepository
 */
class Iconify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IconifyRepository::class;
    }
}
