<?php 
namespace App\Services\Tag\DTOs;

use Spatie\LaravelData\Data;

class ContainsTagData extends Data
{
    public function __construct(
        public bool $contains,
    ) {
    }

    public static function fromArray(array $data): self
    {
        // dd($data);
        return new self(
            $data['contains'],
        );
    }
}