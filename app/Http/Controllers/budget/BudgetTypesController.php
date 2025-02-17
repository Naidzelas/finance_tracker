<?php

namespace App\Http\Controllers\budget;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Icons;
use App\Services\Tag\Repositories\TagRepositoryInterface;
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

        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        $tagService->applyTags();
        event(new NotificationEvent('Budget item has been created'));
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
