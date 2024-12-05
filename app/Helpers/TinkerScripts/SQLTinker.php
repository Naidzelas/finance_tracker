<?php

use App\Models\Expenses\Expense;

function run(){
    $data = Expense::all();
    foreach($data as $item){
        // dump($item->toArray());
        $results[substr($item['date'],0,7)][] = $item->toArray();
    }
    return $results['2024-07'][0];
}