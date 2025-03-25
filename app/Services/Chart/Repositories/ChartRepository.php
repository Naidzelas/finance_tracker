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

        if (Carbon::parse($startDate)->gt(Carbon::parse($endDate))) {
            throw ChartExceptions::invalidDateRange($startDate, $endDate);
        }

        $query = $this->model::select('id', 'type_id', 'debit_credit', 'amount', 'date')->where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate);

        if ($typeIds) {
            $query->whereIn('type_id', $typeIds);
        }

        $expenses = $query->get();

        foreach ($expenses as $expense) {
            $chartData['xAxis'][] = $expense->date;
            $chartData['yAxis'][] = $expense->debit_credit === 'D' ? round(-$expense->amount,2) : round($expense->amount,2);
        }

        return collect($chartData);
    }    
}
