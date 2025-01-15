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
            'method' => 'post',
            'list' => [
                'name'=> ['String',],
                'amount'=>  ['Number',],
                'icon_id' => ['Select',],
                'filter_keys' =>['String',],
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
        return to_route('index');
    }

    public function edit($budgetId)
    {
        $budgetType = BudgetTypes::query()->with('icon')
            ->where('id', $budgetId)
            ->first();

        return Inertia::render('Item',[
            'registerRoute' => 'budget/' . $budgetId,
            'method' => 'put',
            'list' => [
                'name'=> ['String', $budgetType->name],
                'amount'=>  ['Number', $budgetType->amount],
                'icon_id' => ['Select', $budgetType->icon_id],
                'filter_keys' =>['String', $budgetType->filter_keys],
        ],
            'icons' => Icons::query()->get()->toArray(),
        ]);
    }

    public function update(Request $request, $budgetId)
    {
        $budgetType = BudgetTypes::find($budgetId);
        $budgetType->fill($request->all());
        $budgetType->save();
        
        return to_route('index');
    }

    public function destroy($budgetId): void
    {
        BudgetTypes::find($budgetId)->delete();
    }
}
