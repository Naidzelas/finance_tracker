<?php

namespace App\Http\Controllers\budget;

use App\Http\Controllers\Controller;
use App\Models\Budget\BudgetTypes;
use App\Models\Expenses\Expense;
use App\Models\Icons;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetTypesController extends Controller
{
    public function create()
    {
         return Inertia::render('Item',[
            'registerRoute' => 'budget',
            'list' => [
                'name'=> 'String',
                'amount'=>  'Number',
                'icon_id' => 'Select',
                'filter_keys' =>'String',
            ],
            'icons' => Icons::query()->get()->toArray(),
         ]);
    }
    public function store(Request $request, BudgetTypes $budgetTypes)
    {
        // TODO make filter_keys array
        $budgetTypes->fill($request->all());
        $budgetTypes->save();
        $newBudgetItem = $budgetTypes::query()->latest()->limit(1)->first();
        Expense::query()->where('type_id','!=', $newBudgetItem->id)
            ->each(function ($expenseItem) use ($newBudgetItem) {
            if(strpos($expenseItem->transaction_name, $newBudgetItem->filter_keys) 
                || $expenseItem->transaction_name == $newBudgetItem->filter_keys){

                $expenseItem->type_id = $newBudgetItem->id;
                $expenseItem->save();
            }
        });
        return to_route('/');
    }
}
