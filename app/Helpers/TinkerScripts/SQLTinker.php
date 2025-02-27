<?php


use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Debts\Debt;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;
use Carbon\Carbon;

function run()
{

    // $debt = Debt::with(['budgetType.expense:id,type_id,amount'])->get()->map(function ($debt) {
    //     if ($debt->toArray()['budget_type']) {
    //         $debt->paid = array_sum(array_column($debt->toArray()['budget_type']['expense'], 'amount'));
    //     }
    //     return $debt;
    // });

    $debt = Debt::with(['budgetType.expense:id,type_id,amount', 'icon', 'debtDetail', 'documents'])->get()->map(function ($debt) {
        if ($debt->toArray()['budget_type']) {
            $debt->paid = array_sum(array_column($debt->toArray()['budget_type']['expense'], 'amount'));
        }
        return $debt;
    });

    // $debt = BudgetTypes::with('expense')
    // Debt::whereHas('budgetType.expense', function ($query) use ($tagId) {
    //     $query->where('id', $tagId);
    // })
    return $debt;
}
