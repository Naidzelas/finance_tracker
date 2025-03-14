<?php

namespace App\Http\Controllers;

use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Crypt;

class ExpenseListController extends Controller
{
    public function index(Request $request)
    {
        $per_page = request()->input('per_page', 2);
        $data = Expense::query()->select('*')
            ->selectRaw('date_format(date,"%Y-%m") as YM')
            ->groupByRaw('id, YEAR(date), MONTH(date)')
            ->orderByDesc('date')
            ->paginate(10);
        // ->groupBy('YM')->toArray();
        // dd($data);
        // $test = Expense::paginate(10);

        // $paginatedExpenseList = new Paginator($data,  $per_page);

        return Inertia::render('ExpenseList', [
            'expenses' => inertia()->merge(fn() => $data->items()),
            'expenses_paginated' => $data->toArray(),
        ]);
    }

    // TODO possibly make a service for conditional queries.
    public function fetch(Request $request, $container, $year_month)
    {
        $containerData = match ($container) {
            'previous_expenses' => Expense::where('date', '>=', Carbon::parse($year_month)->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::parse($year_month)->endOfMonth()->format('Y-m-d'))
                ->where('user_id', $request->user()->id)
                ->orderBy('date')
                ->get()
                ->toArray(),
            'default' => []
        };

        $encryptedData = Crypt::encrypt($containerData);

        return to_route('index', ['data' => $encryptedData]);
    }

    public function fetchByType(Request $request, $container, $budget_types = null)
    {
        $containerData = match ($container) {
            'current_expenses' => Expense::whereIn('type_id', explode(',', $budget_types))->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
                ->where('user_id', $request->user()->id)
                ->orderBy('date')
                ->get()
                ->toArray(),
            'previous_expenses' => Expense::whereIn('type_id', explode(',', $budget_types))->where('date', '>=', Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d'))
                ->where('user_id', $request->user()->id)
                ->orderBy('date')
                ->get()
                ->toArray(),
            'default' => []
        };

        $encryptedData = Crypt::encrypt($containerData);

        return to_route('index', ['data' => $encryptedData]);
    }
}
