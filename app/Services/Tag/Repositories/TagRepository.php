<?php

namespace App\Services\Tag\Repositories;

use App\Models\Budget\FilterTags;
use App\Services\Tag\DTOs\ContainsTagData;
use App\Services\Tag\Exceptions\TagException;
use Illuminate\Support\Str;



class TagRepository implements TagRepositoryInterface
{
    protected $model;
    protected $availableTags;
    public function __construct(
        $model,
        $availableTags
    ) {
        $this->model = $model;
        $this->availableTags = $availableTags::all();
    }

    public function contains(string $tag, string $seachableString): ContainsTagData
    {
        $tag = '*' . Str::upper($tag) . '*';

        $result = [
            'contains' => Str::is($tag, Str::upper($seachableString))
        ];

        throw_if(!$tag || !$seachableString, TagException::class, 'No tag or searchableString provided');
        return ContainsTagData::fromArray($result);
    }

    public function applyTag()
    {

        return '';
    }

    public function applyTags()
    {
        $this->model::each(function ($model) {
            foreach ($this->availableTags as $avaiableTag) {
                if (self::contains($avaiableTag->tag, $model->transaction_name)->contains) {
                    $model->update(['type_id' => $avaiableTag->budget_type_id]);
                }
            }
        });
    }
}
