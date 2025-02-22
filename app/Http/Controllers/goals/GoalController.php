<?php

namespace App\Http\Controllers\Goals;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\Icons;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Goal', [
            'goals' => Goal::query()->with([
                'icon'
            ])
                ->withSum('goal_deposit as deposit', 'deposit')
                ->get(),
            'detailsTab' => [
                'table' => self::buildDetailTable(),
            ]
        ]);
    }

    public function create()
    {
        $icons = Icons::query()->select('id', 'iconify_name as data')->get()->toArray();
        return Inertia::render('Item', [
            'registerRoute' => 'goal',
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'end_goal' => ['Number',],
                'contribution' => ['Number',],
                'icon_id' => ['Select',],
                'is_main_priority' => ['Boolean',],
                'budget_name' => ['String',],
                'budget_amount' => ['Number',],
                'tags' => ['Tag',],
                'budget_icon_id' => ['Select',],
            ],
            'selectData' => [
                'icon_id' => $icons,
                'budget_icon_id' => $icons
            ]
        ]);
    }

    public function store(Request $request)
    {
    
        $budgetType = BudgetTypes::create([
            'name' => $request->budget_name,
            'amount' => $request->budget_amount,
            'icon_id' => $request->budget_icon_id,
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

        Goal::create([
            'name' => $request->name,
            'end_goal' => $request->end_goal,
            'contribution' => $request->contribution,
            'icon_id' => $request->icon_id,
            'is_main_priority' => $request->is_main_priority,
            'type_id' => $budgetType->id
        ]);

        return to_route('goal.index');
    }

    public function edit($goalId)
    {
        $goal = Goal::find($goalId);

        return Inertia::render('Item', [
            'registerRoute' => 'goal/' . $goalId,
            'method' => 'put',
            'list' => [
                'name' => ['String', $goal->name],
                'end_goal' => ['Number', $goal->end_goal],
                'contribution' => ['Number', $goal->contribution],
                'icon_id' => ['Select', $goal->icon_id],
                'is_main_priority' => ['Boolean', $goal->is_main_priority],
            ],
            'selectData' => [
                'icon_id' => Icons::query()->select('id', 'iconify_name as data')->get()->toArray(),
            ]
        ]);
    }

    public function update(Request $request, $budgetId)
    {
        // dd($request);
        $budgetType = Goal::find($budgetId);
        $budgetType->fill($request->all());
        $budgetType->save();

        return to_route('goal.index');
    }


    public function destroy($goalId): void
    {
        Goal::find($goalId)->delete();
    }

    private function buildDetailTable(): Collection
    {
        $table = [
            'thead' => [
                'Id',
                'Date',
                'Paid',
                'Progress'
            ]
        ];

        $goals = Goal::query()->with(['goal_deposit' => fn($query) =>
            $query->selectRaw('goal_id, SUM(deposit) as deposit, concat(year(updated_at), "/",  month(updated_at)) as date')
                ->groupByRaw('goal_id, concat(year(updated_at), "/",  month(updated_at))')
        ])->get()->toArray();

        $i = 1;
        foreach ($goals as $goal) {
            if (!$goal['goal_deposit']) {
                $table[$goal['id']]['tbody'][] = [
                    1,
                    'No Data',
                    'No Data',
                    'No Data',
                ];
                continue;
            }
            foreach ($goal['goal_deposit'] as $deposit) {
                $table[$goal['id']]['tbody'][] = [
                    $i++,
                    $deposit['date'],
                    $deposit['deposit'] . ' / ' . $goal['contribution'],
                    'Nothing',
                ];
            }
        }

        return collect($table);
    }
}
