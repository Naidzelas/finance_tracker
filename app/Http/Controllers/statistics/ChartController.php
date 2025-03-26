<?php

namespace App\Http\Controllers\statistics;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\ChartService;
use App\Models\Expenses\Expense;
use App\Services\Chart\Exceptions\ChartExceptions;
use App\Services\Chart\Repositories\ChartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ChartController extends Controller
{

    public function chartData(Request $request)
    {
        $chartRepository = app(ChartRepositoryInterface::class, ['model' => Expense::class]);
        $chartService = new ChartService($chartRepository);
        $user = $request->user();

        $startDate = $request->startDate;
        $endDate =  $request->endDate;
        $typeIds = $request->typeId;

        if ($typeIds && is_string($typeIds)) {
            $typeIds = explode(',', $typeIds);
        }

        try {
            $chartData = $chartService->getChartDataByType(
                $user->id,
                $request->chartType,
                $typeIds,
                $startDate,
                $endDate
            );
            $encryptedData = Crypt::encrypt($chartData);
            return to_route('profile.index', ['chartData' => $encryptedData]);
        } catch (ChartExceptions $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
