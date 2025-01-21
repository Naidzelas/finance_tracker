<?php 
namespace App\Services\Etoro\DTOs;

use Spatie\LaravelData\Data;

class InstrumentBySymbolData extends Data
{
    public function __construct(
        public array $instrument,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['instrument'],
        );
    }
}