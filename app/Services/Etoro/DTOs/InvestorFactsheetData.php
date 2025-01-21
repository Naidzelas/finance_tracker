<?php 
namespace App\Services\Etoro\DTOs;

use Spatie\LaravelData\Data;

class InvestorFactsheetData extends Data
{
    public function __construct(
        public array $portfolio,
        public array $history,
        public array $returns
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['portfolio'],
            $data['history'],
            $data['returns']
        );
    }
}