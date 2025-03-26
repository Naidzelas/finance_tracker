<?php

namespace App\Services\Chart\Facades;

use App\Services\Chart\Repositories\ChartRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getLineChartDataByType(int $userId, ?string $startDate = null, ?string $endDate = null, ?array $typeIds = null)
 * @method static \Illuminate\Support\Collection getMonthlyChartData(int $userId, int $months = 6, ?array $typeIds = null)
 *
 * @see \App\Services\ChartService
 */
class Chart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ChartRepository::class;
    }
}
