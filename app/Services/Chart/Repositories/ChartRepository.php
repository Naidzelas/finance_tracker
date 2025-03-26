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

        $expenses = $query->get();

        if ($expenses->isEmpty()) {
            return collect([]);
        }

        $chartData = [];

        if (count($typeIds) < 2) {

            $groupedByDate = $expenses->groupBy('date');

            foreach ($groupedByDate as $date => $dateExpenses) {
                $netAmount = 0;
                foreach ($dateExpenses as $expense) {
                    $amount = $expense->debit_credit === 'D' ? -$expense->amount : $expense->amount;
                    $netAmount += $amount;
                }
                $chartData['yAxis'][] = [$date, round($netAmount, 2)];
            }
        } else {
            $groupedByType = $expenses->groupBy('type_id');

            foreach ($groupedByType as $typeId => $typeExpenses) {
                $chartData[$typeId] = [
                    'yAxis' => []
                ];

                $groupedByDate = $typeExpenses->groupBy('date');

                foreach ($groupedByDate as $date => $dateExpenses) {
                    $netAmount = 0;
                    foreach ($dateExpenses as $expense) {
                        $amount = $expense->debit_credit === 'D' ? -$expense->amount : $expense->amount;
                        $netAmount += $amount;
                    }
                    $chartData[$typeId]['yAxis'][] = [$date, round($netAmount, 2)];
                }
            }
        }
        $chartData['period'] = $dateRange;

        return collect($chartData);
    }
}
