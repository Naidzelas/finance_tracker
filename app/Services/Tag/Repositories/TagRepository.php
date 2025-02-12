<?php

namespace App\Services\Tag\Repositories;

use App\Services\Tag\DTOs\ContainsTagData;
use App\Services\Tag\Exceptions\TagException;
use Illuminate\Support\Str;



class TagRepository implements TagRepositoryInterface
{
    public function __construct() {}

    public function contains(string $tag, string $searchableArray): ContainsTagData
    {
        $tag = '*' . Str::upper($tag) . '*';

        $result = [
            'contains' => Str::is($tag, $searchableArray)
        ];
        
        throw_if(!$tag || !$searchableArray, TagException::class, 'No tag or hay provided');
        return ContainsTagData::fromArray($result);
    }

    public function applyTag()
    {
        return '';
    }

    public function applyTags()
    {
        return '';
    }
}
