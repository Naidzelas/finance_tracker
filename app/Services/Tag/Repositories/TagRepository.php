<?php

namespace App\Services\Tag\Repositories;

use App\Services\Tag\DTOs\ContainsTagData;
use App\Services\Tag\Exceptions\TagException;
use Illuminate\Support\Str;



class TagRepository implements TagRepositoryInterface
{
    protected $model;
    protected $availableTags;
    private const UNDEFINED = 1;
    public function __construct(
        $model,
        $availableTags
    ) {
        $this->model = $model;
        $this->availableTags = $availableTags::all();
    }

    public function contains(string $tag, string $seachableString): ContainsTagData
    {
        if (!$seachableString || !$tag) {
            return ContainsTagData::fromArray(['contains' => false]);
        };

        $tag = '*' . Str::upper($tag) . '*';

        $result = [
            'contains' => Str::is($tag, Str::upper($seachableString))
        ];

        throw_if(!$tag || !$seachableString, TagException::class, 'No tag or searchableString provided');
        return ContainsTagData::fromArray($result);
    }

    public function applyTag()
    {
        throw_if(!$this->model || !$this->availableTags, TagException::class, 'Model does not exist or there are no availableTags');

        foreach ($this->availableTags as $avaiableTag) {
            if (self::contains($avaiableTag->tag, $this->model->transaction_name)->contains) {
                $this->model->update(['type_id' => $avaiableTag->budget_type_id]);
            }
        }
    }

    public function applyTags()
    {
        throw_if(!$this->model || !$this->availableTags, TagException::class, 'Model does not exist or there are no availableTags');

        $this->model::each(function ($model) {
            foreach ($this->availableTags as $avaiableTag) {
                if (self::contains($avaiableTag->tag, $model->transaction_name)->contains) {
                    $model->update(['type_id' => $avaiableTag->budget_type_id]);
                }
            }
        });
    }

    public function removeTagsById(int $tagId)
    {
        throw_if(!$tagId, TagException::class, 'No Tag ID provided');

        $this->model::whereHas('budgetType.tag', function ($query) use ($tagId) {
            $query->where('id', $tagId);
        })->each(function ($query) {
            $query->update(['type_id' => self::UNDEFINED]);
        });
    }

    public function applyTagsByIban(string $iban, int $id)
    {
        $this->model::each(function ($model) use ($iban, $id) {
            if (self::contains($iban, $model->iban ?? '')->contains) {
                $model->update(['type_id' => $id]);
            }
        });
    }
    public function removeTagsByIban(string $iban) 
    {
        $this->model::each(function ($model) use ($iban) {
            if (self::contains($iban, $model->iban ?? '')->contains) {
                $model->update(['type_id' => self::UNDEFINED]);
            }
        });
    }
}
