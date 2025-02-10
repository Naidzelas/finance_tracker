<?php

namespace App\Http\Controllers;

use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Inertia\Inertia;

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
    
    // TODO possibly move this to expense controller or refactor to just update previous_expenses.
    public function fetch($yearMonth)
    {
        return Inertia::render('Home', [
            'current_expenses' => Expense::where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))
                ->orderBy('date')
                ->get(),
            'previous_expenses' => Expense::where('date', '>=', Carbon::parse($yearMonth)->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::parse($yearMonth)->endOfMonth()->format('Y-m-d'))
                ->orderBy('date')
                ->get(),
            'goals' => Goal::query()->with('icon')->withSum('goal_deposit as deposit', 'deposit')->get(),
            'budget_types' => BudgetTypes::query()->with('icon')->get()->toArray(),
        ]);
    }
}
