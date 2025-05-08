<?php

namespace App\Services\Chart\Repositories;

use App\Services\Chart\Exceptions\ChartExceptions;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ChartRepository implements ChartRepositoryInterface
{
    protected $model;
    public function __construct(
        $model,
    ) {
        $this->model = $model;
    }

    /**
     * Get chart data grouped by dateQuery types
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
        ?string $endDate = null
    ): Collection {
        $startDate ??= Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate ??= Carbon::now()->endOfMonth()->format('Y-m-d');

        $dateRange = [];
        $currentDate = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);

        while ($currentDate->lte($endDateCarbon)) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        if (Carbon::parse($startDate)->gt(Carbon::parse($endDate))) {
            report(ChartExceptions::invalidDateRange($startDate, $endDate));
        }

        $query = $this->model::select('id', 'type_id', 'debit_credit', 'amount', 'date')
            ->where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate);

        if ($typeIds) {
            $query->whereIn('type_id', $typeIds);
        }

        $queryResults = $query->get();

        if ($queryResults->isEmpty()) {
            return collect([]);
        }

        $chartData = [];

        if (count($typeIds) < 2) {

            $groupedByDate = $queryResults->groupBy('date')->sortKeys();
            foreach ($groupedByDate as $date => $dateQueryResult) {
                $netAmount = 0;
                foreach ($dateQueryResult as $dateQuery) {
                    $amount = $dateQuery->debit_credit === 'D' ? -$dateQuery->amount : $dateQuery->amount;
                    $netAmount += abs($amount);
                }
                $chartData['yAxis'][] = [$date, round($netAmount, 2)];
            }
        } else {
            $groupedByType = $queryResults->groupBy('type_id');

            foreach ($groupedByType as $typeId => $typeQueryResult) {
                $chartData[$typeId] = [
                    'yAxis' => []
                ];

                $groupedByDate = $typeQueryResult->groupBy('date');

                foreach ($groupedByDate as $date => $dateQueryResult) {
                    $netAmount = 0;
                    foreach ($dateQueryResult as $dateQuery) {
                        $amount = $dateQuery->debit_credit === 'D' ? -$dateQuery->amount : $dateQuery->amount;
                        $netAmount += $amount;
                    }
                    $chartData[$typeId]['yAxis'][] = [$date, round($netAmount, 2)];
                }
            }
        }
        $chartData['period'] = $dateRange;

        return collect($chartData);
    }

    public function getPieChartDataCurrentBudgetAllocation(
        int $userId
    ): Collection {

        $query = $this->model::select('id', 'name', 'amount')
            ->where('user_id', $userId);

        $queryResults = $query->get();

        if ($queryResults->isEmpty()) {
            return collect([]);
        }

        $chartData = [];

        foreach ($queryResults as $result) {
            $chartData[] = [
                'value' => round($result->amount, 2),
                'name' => $result->name
            ];
        }

        return collect($chartData);
    }

    public function getLineChartDataToCompare(
        int $userId,
        ?string $compareDate,
        ?array $typeIds = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): Collection {
        $startDate ??= Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate ??= Carbon::now()->endOfMonth()->format('Y-m-d');

        if ($compareDate) {
            $compareCarbon = Carbon::parse($compareDate);
            $startCompare = $compareCarbon->copy()->month(Carbon::parse($startDate)->month)->startOfMonth()->format('Y-m-d');
            $endCompare = $compareCarbon->copy()->month(Carbon::parse($endDate)->month)->endOfMonth()->format('Y-m-d');
        }

        $chartDataMain = $this->getLineChartDataByType(
            $userId,
            $typeIds,
            $startDate,
            $endDate
        );

        $compareQuery = $this->model::select('id', 'type_id', 'debit_credit', 'amount', 'date')
            ->where('user_id', $userId)
            ->where('date', '>=', $startCompare)
            ->where('date', '<=', $endCompare);


            if ($typeIds) {
                $compareQuery->whereIn('type_id', $typeIds);
            }
    
            $queryResults = $compareQuery->get();
    
            if ($queryResults->isEmpty()) {
                return collect([]);
            }
    
            $chartData = [];
    
            if (count($typeIds) < 2) {
    
                $groupedByDate = $queryResults->groupBy('date')->sortKeys();
    
                foreach ($groupedByDate as $date => $dateQueryResult) {
                    $netAmount = 0;
                    foreach ($dateQueryResult as $dateQuery) {
                        $amount = $dateQuery->debit_credit === 'D' ? -$dateQuery->amount : $dateQuery->amount;
                        $netAmount += $amount;
                    }
                    $chartData['yAxis'][] = [$date, round($netAmount, 2)];
                }
            } else {
                $groupedByType = $queryResults->groupBy('type_id');
    
                foreach ($groupedByType as $typeId => $typeQueryResult) {
                    $chartData[$typeId] = [
                        'yAxis' => []
                    ];
    
                    $groupedByDate = $typeQueryResult->groupBy('date');
    
                    foreach ($groupedByDate as $date => $dateQueryResult) {
                        $netAmount = 0;
                        foreach ($dateQueryResult as $dateQuery) {
                            $amount = $dateQuery->debit_credit === 'D' ? -$dateQuery->amount : $dateQuery->amount;
                            $netAmount += $amount;
                        }
                        $chartData[$typeId]['yAxis'][] = [$date, round($netAmount, 2)];
                    }
                }
            }

            $comparedData = [
                'compareData' => $chartData,
                'mainData' => $chartDataMain['yAxis'],
                'period' => $chartDataMain['period'],
            ];
            // dd($comparedData);

            return collect($chartData);
    }
}
