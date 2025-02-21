<?php


use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use Carbon\Carbon;

function run()
{

    // $expense = Expense::currentPostway('D');
    $budget = BudgetTypes::query()->with([
        'icon',
        'tag'
    ])->get()->toArray();

    return $budget;
}
