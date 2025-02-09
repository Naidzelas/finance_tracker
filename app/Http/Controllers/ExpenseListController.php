<?php

namespace App\Http\Controllers;

use App\Models\Expenses\Expense;
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
}
