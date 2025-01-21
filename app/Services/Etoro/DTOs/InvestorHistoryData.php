<?php 
namespace App\Services\Etoro\DTOs;

use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Data;

class InvestorHistoryData extends Data
{
    public function __construct(
        public array $instruments,
        public array $daily,

    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['insturments'],
            $data['daily']
        );
    }
}