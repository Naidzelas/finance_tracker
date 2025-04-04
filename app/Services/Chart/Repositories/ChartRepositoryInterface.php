<?php

namespace App\Services\Chart\Repositories;

use Illuminate\Support\Collection;

interface ChartRepositoryInterface
{
    /**
     * Get chart data grouped by expense types
     * 
     * @param int $userId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param array|null $typeIds
     * @return Collection
     */
    public function getLineChartDataByType(
        int $userId, 
        ?array $typeIds = null,
        ?string $startDate = null, 
        ?string $endDate = null, 
    ): Collection;

    public function getPieChartDataCurrentBudgetAllocation(
        int $userId, 
    ): Collection;

    public function getLineChartDataToCompare(
        int $userId, 
        ?string $compareDate,
        ?array $typeIds = null,
        ?string $startDate = null, 
        ?string $endDate = null
    ): Collection;
}
