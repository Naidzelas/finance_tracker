<?php

namespace App\Http\Controllers;

use App\Http\Controllers\features\SEBImportExpensesController;
use App\Models\Expenses\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class ExpenseController extends Controller
{
    public function index(Expense $expense)
    {
        return Inertia::render('Home',[
            'expenses' => $expense->all()->map(function ($expense){
                return [
                    'id' => $expense->id,
                    'type_id' => $expense->type_id,
                    'amount' => $expense->amount,
                    'currency' => $expense->currency,
                    'debit_credit' => $expense->debit_credit,
                    'date' => $expense->date
                ];
            })
        ]);
    }

    public function store(Request $request, Expense $expense)
    {
        // dd($request->avatar->path());
        switch('seb'){
            case 'seb':
                $seb = new SEBImportExpensesController;
                $data = $seb($request->avatar->path());
                break;
            default: 
        }

        foreach($data as $item){
            $expense->create([
                'type_id' => 1,
                'amount' => (float) $item['amount'],
                'date' => $item['transaction_date'],
                'debit_credit' => $item['debit_credit'],
                'currency' => $item['currency'],
            ]); 
        }

        return to_route('/');
    }

}
