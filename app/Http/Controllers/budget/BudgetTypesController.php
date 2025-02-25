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
    public function index()
    {
        return to_route('index');
    }
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
        $budgetType = BudgetTypes::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'icon_id' => $request->icon_id,
        ]);

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                FilterTags::create([
                    'budget_type_id' => $budgetType->id,
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
        $budgetType = BudgetTypes::with(['icon', 'tag'])->find($budgetId);

        return Inertia::render('Item', [
            'registerRoute' => 'budget/' . $budgetId,
            'method' => 'put',
            'list' => [
                'name' => ['String', $budgetType->name],
                'amount' =>  ['Number', $budgetType->amount],
                'icon_id' => ['Select', $budgetType->icon_id],
                'tags' => ['Tag', $budgetType->tag],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function update(Request $request, $budgetId)
    {
        $filterTags = FilterTags::where('budget_type_id', $budgetId)->get();
        $budgetType = BudgetTypes::find($budgetId);
        $budgetType->fill($request->all());
        $budgetType->save();

        // TODO this need as fix.. when tags are unchanged this first or new breaks.
        if ($request->tags) {
            foreach ($request->tags as $tag) {
                FilterTags::firstOrNew([
                    'budget_type_id' => $budgetId,
                    'tag' => $tag,
                ])->save();
            }
        };

        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        $tagService->applyTags();

        foreach ($filterTags as $filterTag) {
            if (!in_array($filterTag->tag, $request->tags)) {
                $tagService->removeTagsById($filterTag->id);
                $filterTag->delete();
                event(new NotificationEvent('Tag Removed'));
            }
        }

        event(new NotificationEvent('Budget item has been updated'));
        return to_route('index');
    }

    public function destroy($budgetId): void
    {
        $filterTags = FilterTags::where('budget_type_id', $budgetId)->get();
        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        foreach ($filterTags as $filterTag) {
            $tagService->removeTagsById($filterTag->id);
            $filterTag->delete();
            event(new NotificationEvent('Tag Removed'));
        }
        BudgetTypes::find($budgetId)->delete();
        event(new NotificationEvent('Budget item has been deleted'));
    }
}
