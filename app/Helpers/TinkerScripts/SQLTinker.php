<?php


use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;
use Carbon\Carbon;

function run()
{
    // $expenses = Expense::where('type_id', 41)
    //     ->select('date', 'debit_credit', 'amount')
    //     ->get()
    //     ->groupBy('date')
    //     ->map(function ($item) {
    //         $item->put('deposit', $item->where('debit_credit', 'D')->sum('amount') - $item->where('debit_credit', 'C')->sum('amount'));
    //         return $item;
    //     })->toArray();

    // $goalDeposit = GoalDeposit::selectRaw('goal_id, deposit, concat(year(date), "/",  month(date)) as date')->with('goal')
    //     ->get()->groupBy('goal_id')->toArray();

    $goals = Goal::with('goal_deposit:id,goal_id,deposit,date')->select('id','contribution')->get()->map(function ($query) {
        foreach ($query->goal_deposit as $deposit) {
            $value[substr($deposit->date, 0, 7)][] = [
                'goal_id' => $deposit->goal_id,
                'deposit' => $deposit->deposit
            ];
            $query->stuff = $value;
        };
        return $query;
    })->toArray();

    // $goalDeposits = Expense::where('type_id', 53)
    //         ->select('date', 'debit_credit', 'amount')
    //         ->get()
    //         ->map(function ($item) {
    //             $item->result = $item->where('type_id', 53)->where( 'debit_credit', 'C')->groupByRaw('year(date), month(date)')->sum('amount');
    //             $item->test = $item->where('type_id', 53)->where('debit_credit', 'C')->groupByRaw('year(date), month(date)');
    //             // dump($item->where('type_id', 53)->where('debit_credit', 'C')->groupByRaw('year(date), month(date)')->sum('amount'));
    //             // $item->stuff = $item->where('debit_credit', 'D')->sum('amount');
    //             return $item;
    //         })->toArray();

    return $goals;
}
