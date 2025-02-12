<?php

namespace App\Http\Controllers\budget;

use App\Http\Controllers\Controller;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Icons;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetTypesController extends Controller
{
    public function create()
    {
        return Inertia::render('Item', [
            'registerRoute' => 'budget',
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'amount' =>  ['Number',],
                'icon_id' => ['Select',],
                'tags' => ['Tag',],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }
    public function store(Request $request)
    {
        $budgetTypes = BudgetTypes::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'icon_id' => $request->icon_id,
        ]);

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                FilterTags::create([
                    'budget_type_id' => $budgetTypes->id,
                    'tag' => $tag,
                ]);
            }
        };

        $filter = FilterTags::find($budgetTypes->id);
        // Expense::query()->where('type_id', '!=', $budgetTypes->id)
        //     ->each(function ($expenseItem) use ($filter) {
        //         if (
        //             strpos($expenseItem->transaction_name, $filter->filter_keys)
        //             || $expenseItem->transaction_name == $filter->filter_keys
        //         ) {

        //             $expenseItem->type_id = $newBudgetItem->id;
        //             $expenseItem->save();
        //         }
        //     });
        return to_route('index');
    }

    public function edit($budgetId)
    {
        $budgetType = BudgetTypes::query()->with('icon')
            ->where('id', $budgetId)
            ->first();

        return Inertia::render('Item', [
            'registerRoute' => 'budget/' . $budgetId,
            'method' => 'put',
            'list' => [
                'name' => ['String', $budgetType->name],
                'amount' =>  ['Number', $budgetType->amount],
                'icon_id' => ['Select', $budgetType->icon_id],
                'tags' => ['Tag'],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
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
