<?php


use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use Carbon\Carbon;

function run()
{

    // $expense = Expense::currentPostway('D');
    $budget = BudgetTypes::query()->with([
        'icon',
    ])->get()
    ->map(function ($item) {
        $item->budget_left = $item->amount + Expense::currentPostway('D')
            ->where('type_id',$item->id)
            ->sum('amount') -  Expense::currentPostway()->where('type_id',$item->id)->sum('amount');
        return $item;
    });

    return $budget;
}
