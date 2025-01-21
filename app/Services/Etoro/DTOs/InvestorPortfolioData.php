<?php 
namespace App\Services\Etoro\DTOs;

use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Data;

class InvestorPortfolioData extends Data
{
    public function __construct(
        public Decimal $balance,
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