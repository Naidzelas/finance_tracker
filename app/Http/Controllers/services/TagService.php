<?php 

namespace App\Http\Controllers\Services;

use App\Services\Tag\Facades\Tag;
use App\Services\Tag\Exceptions\TagException;
use App\Services\Tag\Repositories\TagRepositoryInterface;

class TagService
{

    // public function __construct(
    //     protected TagRepositoryInterface $tagRepository
    // ){

    // }

    public function contains(string $tag, string $searchableArray)
    {
        try {
            /** @var \App\Services\Tag\DTOs\ContainsTagData */
           $tag = Tag::contains($tag,$searchableArray);

        } catch (TagException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'contains' => $tag->contains,
        ]);
    }
}


