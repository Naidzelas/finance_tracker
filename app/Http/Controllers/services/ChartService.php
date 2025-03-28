<?php

namespace App\Http\Controllers\Services;

use App\Services\Chart\Exceptions\ChartExceptions;
use App\Services\Chart\Repositories\ChartRepositoryInterface;


class ChartService
{
    protected $chartRepository;

    public function __construct(
        ChartRepositoryInterface $chartRepository
    ) {
        $this->chartRepository = $chartRepository;
    }

    public function getChartDataByType($userId, $chartType, $typeIds = null, $startDate = null, $endDate = null)
    {
        return match ($chartType) {
            'line' => $this->chartRepository->getLineChartDataByType($userId, $typeIds, $startDate, $endDate),
            // 'bar' =>  $this->chartRepository->getBarChartDataByType($userId, $typeIds, $startDate, $endDate),
            'pie' =>  $this->chartRepository->getPieChartDataCurrentBudgetAllocation($userId),
            default => throw new ChartExceptions('Invalid chart type')
        };
    }

    public function getChartDataToCompare($userId, $chartType, $compareDate,  $typeIds = null, $startDate = null, $endDate = null)
    {
        return match ($chartType) {
            'line' => $this->chartRepository->getLineChartDataToCompare($userId, $compareDate, $typeIds, $startDate, $endDate),
            default => throw new ChartExceptions('Invalid chart type')
        };
    }
}
