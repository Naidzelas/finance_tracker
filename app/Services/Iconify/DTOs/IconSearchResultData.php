<?php 
namespace App\Services\Iconify\DTOs;

use Spatie\LaravelData\Data;

class IconSearchResultData extends Data
{
    public function __construct(
        public array $icons,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['icons'],
        );
    }
}
