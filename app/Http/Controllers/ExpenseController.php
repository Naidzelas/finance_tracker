<?php

namespace App\Http\Controllers;

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Http\Controllers\features\SWEDImportExpensesController;
use App\Models\Expenses\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(Expense $expense)
    {
        return Inertia::render('Home',[
            'expenses' => $expense->all()->toArray()
        ]);
    }

    public function store(Request $request, Expense $expense)
    {
        switch($request->bank){
            case 'seb':
                $seb = new SEBImportExpensesController;
                $data = $seb($request->avatar->path());
                break;
            case 'swed':
                $swed = new SWEDImportExpensesController;
                $data = $swed($request->avatar->path());
                break;
            default: 
        }

        foreach($data as $item){
            $expense->create([
                'type_id' => 1,
                'transaction_name' => $item['transaction_name'],
                'amount' => (float) $item['amount'],
                'date' => $item['transaction_date'],
                'debit_credit' => $item['debit_credit'],
                'currency' => $item['currency'],
            ]); 
        }

        // return to_route('Home');
    }

}
