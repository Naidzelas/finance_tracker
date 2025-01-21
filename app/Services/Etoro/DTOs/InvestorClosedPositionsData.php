<?php 
namespace App\Services\Etoro\DTOs;

use Spatie\LaravelData\Data;

class InvestorClosedPositionsData extends Data
{
    public function __construct(
        public array $positions,
        public array $instruments
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['positions'],
            $data['insturments']
        );
    }
}