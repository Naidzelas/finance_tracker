<?php

namespace App\Http\Controllers\budget;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\services\IconifyController;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class BudgetTypesController extends Controller
{
    public function index()
    {
        return to_route('index');
    }
    public function create(Request $request)
    {
        if (RequestFacade::input('search')) {
            $suggestions = self::suggestTag(RequestFacade::input('search'));
        }

        if (RequestFacade::input('suggestIcon')) {
            $icons = new IconifyController();
            $suggestionsIcon = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
        }

        return Inertia::render('Item', [
            'registerRoute' => 'budget',
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Budget',
                    'route' => '/budget'
                ],
                [
                    'label' => 'Create',
                    'route' => '/budget/create'
                ]
            ],
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'amount' =>  ['Number',],
                'iconify_name' => ['Select',],
                'tags' => ['Tag',],
            ],
            'selectData' => [
                'iconify_name' => $suggestionsIcon->icons ?? [],
                'tag_suggestions' => $suggestions ?? [],
            ],
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'iconify_name' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        $budgetType = BudgetTypes::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'amount' => $request->amount,
            'iconify_name' => $request->iconify_name,
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
        $budgetType = BudgetTypes::with('tag')->find($budgetId);

        if (RequestFacade::input('search')) {
            $suggestions = self::suggestTag(RequestFacade::input('search'));
        }

        if (RequestFacade::input('suggestIcon')) {
            $icons = new IconifyController();
            $suggestionsIcon = $icons->searchIcons(RequestFacade::input('suggestIcon'))->getData();
        }

        return Inertia::render('Item', [
            'registerRoute' => 'budget/' . $budgetId,
            'breadcrumbs' => [
                [
                    'label' => 'Home',
                    'route' => '/'
                ],
                [
                    'label' => 'Budget',
                    'route' => '/budget'
                ],
                [
                    'label' => 'Edit',
                    'route' => '/budget' . '/' . $budgetId . '/edit'
                ]
            ],
            'method' => 'put',
            'list' => [
                'name' => ['String', $budgetType->name],
                'amount' =>  ['Number', $budgetType->amount],
                'iconify_name' => ['Select', $budgetType->iconify_name],
                'tags' => ['Tag', $budgetType->tag],
            ],
            'selectData' => [
                'iconify_name' => $suggestionsIcon->icons ?? [],
                'tag_suggestions' => $suggestions ?? [],
            ]
        ]);
    }

    public function update(Request $request, $budgetId)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'iconify_name' => 'required|string',
            'tags' => 'nullable|array',
        ]);

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

    private function suggestTag($searchInput)
    {
        return Expense::select('transaction_name')
            ->distinct()
            ->when($searchInput, function ($data, $search) {
                $searchString = '%' . $search . '%';
                $data->where('transaction_name', 'like', $searchString);
            })->limit(5)
            ->get();
    }
}
