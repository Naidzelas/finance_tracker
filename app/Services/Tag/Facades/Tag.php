<?php 
namespace App\Services\Tag\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Tag\Repositories\TagRepository;

/**
 * @see \App\Services\Tag\Repositories\TagRepository
 */
class Tag extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TagRepository::class;
    }
}