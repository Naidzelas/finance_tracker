<?php

namespace App\Services\Chart\DTOs;

use Spatie\LaravelData\Data;

class ChartDataDTO extends Data
{
    public function __construct(
        public int $typeId,
        public string $typeName,
        public ?string $icon,
        public string $color,
        public float $debitTotal,
        public float $creditTotal,
        public float $netTotal,
        public int $transactionCount,
        public float $percentage = 0
    ) {
    }
}
