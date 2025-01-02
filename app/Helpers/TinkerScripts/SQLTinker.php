<?php

use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;

function run(){
    $budgetTypes = BudgetTypes::all()->keyBy('filter_keys');
    dump($budgetTypes->toArray());
    // array_filter($budgetTypes, function($test){
    //     if(strpos($test['filter_keys'],'SEB bankas') || $test['filter_keys'] == 'SEB bankas'){
    //         dump($test);
    //     }
    //     // dump($test['filter_keys']);
    // });
    // $budgetTypes = BudgetTypes::query()->where('id',operator: 23)->first();
    // Expense::query()->first()->each(function ($item) use ($budgetTypes) {
    //     if(strpos($item->transaction_name, $budgetTypes->filter_keys) 
    //         || $item->transaction_name == $budgetTypes->filter_keys){
    //         dump($item);
    //         $item->type_id = $budgetTypes->id;
    //         $item->save();
    //     }
    // });
}