<?php

namespace App\Services\Tag\Repositories;

use App\Services\Tag\DTOs\ContainsTagData;

interface TagRepositoryInterface
{

    public function contains(string $tag, string $seachableString): ContainsTagData;
    public function applyTag();
    public function applyTags();
}
