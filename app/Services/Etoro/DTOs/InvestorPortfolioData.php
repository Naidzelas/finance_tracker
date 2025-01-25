<?php 
namespace App\Services\Etoro\DTOs;

use Spatie\LaravelData\Data;

class InvestorPortfolioData extends Data
{
    public function __construct(
        public float $balance,
        public array $positions,

    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['balance'],
            $data['positions']
        );
    }
}