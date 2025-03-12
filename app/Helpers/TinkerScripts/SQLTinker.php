<?php

use App\Models\Expenses\Expense;

function run()
{
    $result = Expense::where('type_id', 5)
    ->where('user_id', 1)
    ->select('date', 'debit_credit', 'amount')
    ->get()
    ->groupBy('date')
    ->map(function ($item) {
        $item = $item->merge(['deposit' => $item->where('debit_credit', 'D')
            ->sum('amount') - $item->where('debit_credit', 'C')->sum('amount')]);
        return $item;
    })->toArray();
    
    return $result;
}
