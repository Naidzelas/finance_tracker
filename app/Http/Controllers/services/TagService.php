<?php

namespace App\Http\Controllers\Services;

use App\Models\Budget\FilterTags;
use App\Services\Tag\Facades\Tag;
use App\Services\Tag\Exceptions\TagException;
use App\Services\Tag\Repositories\TagRepositoryInterface;

class TagService
{
    protected $tagRepository;
    public function __construct(
        TagRepositoryInterface $tagRepository
    ) {
        $this->tagRepository = $tagRepository;
    }

    public function contains(string $tag, string $seachableString)
    {
        try {
            /** @var \App\Services\Tag\DTOs\ContainsTagData */
            $tag = Tag::contains($tag, $seachableString);
        } catch (TagException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json([
            'contains' => $tag->contains,
        ]);
    }
    public function applyTags()
    {
        try {
            /** @var \App\Services\Tag\DTOs\ContainsTagData */
            $this->tagRepository->applyTags();
        } catch (TagException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
