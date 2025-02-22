<?php


use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use Carbon\Carbon;

function run()
{

    // $expense = Expense::currentPostway('D');
    $filterTags = FilterTags::where('budget_type_id', 4)->get();

    return $filterTags->map(function($filter){
        return $filter->tag;
    })->toArray();
}
