<?php

namespace App\Http\Controllers;

use App\Models\Expenses\Expense;
use Inertia\Inertia;

class ExpenseListController extends Controller
{
    public function index(Expense $expense)
    {
        $data = $expense::all()->sortByDesc('date',);
        foreach($data as $item){
            $expenses[substr($item['date'],0,7)][] = $item->toArray();
        }
        
        return Inertia::render('ExpenseList',[
            'expenses' => $expenses
        ]);
    }
}
