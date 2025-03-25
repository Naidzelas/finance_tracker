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

    public function getChartDataByType($userId, $chartType, $typeIds, $startDate, $endDate)
    {
        return match($chartType){
            'line' => $this->chartRepository->getLineChartDataByType($userId, $typeIds, $startDate, $endDate),
            // 'bar' =>  $this->chartRepository->getBarChartDataByType($userId, $typeIds, $startDate, $endDate),
            // 'pie' =>  $this->chartRepository->getPieChartDataByType($userId, $typeIds, $startDate, $endDate),
            default => throw new ChartExceptions('Invalid chart type')
        };
        // return $this->chartRepository->getLineChartDataByType($userId, $typeIds, $startDate, $endDate);
    }
}
