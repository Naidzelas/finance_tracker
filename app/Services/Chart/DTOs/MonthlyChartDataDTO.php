<?php

namespace App\Services\Chart\DTOs;

use Spatie\LaravelData\Data;

class MonthlyChartDataDTO extends Data
{
    public function __construct(
        public string $month,
        public string $monthLabel,
        public float $debitTotal,
        public float $creditTotal,
        public float $netTotal,
        public int $transactionCount
    ) {
    }
}
