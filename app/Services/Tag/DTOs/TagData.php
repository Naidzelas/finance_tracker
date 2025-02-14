<?php 
namespace App\Services\Tag\DTOs;

use Spatie\LaravelData\Data;

class TagData extends Data
{
    public function __construct(
        public array $tag,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['tag'],
        );
    }
}