<?php

namespace App\Http\Controllers\Goals;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;
use App\Models\Icons;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Inertia::render('Goal', [
            'goals' => Goal::where('user_id', $user->id)->with([
                'icon'
            ])
                ->withSum('goal_deposit as deposit', 'deposit')
                ->get(),
            'detailsTab' => [
                'table' => self::buildDetailTable($user),
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
                'saving_account_iban' => ['String',],
            ],
            'selectData' => [
                'icon_id' => $icons,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'end_goal' => 'required|numeric',
            'contribution' => 'required|numeric',
            'icon_id' => 'required|integer',
            'is_main_priority' => 'required|boolean',
            'saving_account_iban' => 'nullable|string',
        ]);

        $user = $request->user();
        $budgetType = BudgetTypes::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'amount' => $request->contribution,
            'icon_id' => $request->icon_id,
        ]);

        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        if ($request->saving_account_iban != null) {
            $tagService->applyTagsByIban($request->saving_account_iban, $budgetType->id);
        }
        event(new NotificationEvent('Budget item has been created'));

        $goal = Goal::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'end_goal' => $request->end_goal,
            'contribution' => $request->contribution,
            'icon_id' => $request->icon_id,
            'is_main_priority' => $request->is_main_priority,
            'type_id' => $budgetType->id,
            'saving_account_iban' => $request->saving_account_iban
        ]);

        // TODO absolute disaster, will need to revisit and refactor
        $goalDeposits = Expense::where('type_id', $budgetType->id)
            ->where('user_id', $user->id)
            ->select('date', 'debit_credit', 'amount')
            ->get()
            ->groupBy('date')
            ->map(function ($item) {
                $item->put('deposit', $item->where('debit_credit', 'D')
                    ->sum('amount') - $item->where('debit_credit', 'C')->sum('amount'));
                return $item;
            })->toArray();

        foreach ($goalDeposits as $date => $goalDeposit) {
            if ($goalDeposit['deposit'] > 0) {
                GoalDeposit::updateOrCreate([
                    'goal_id' => $goal->id,
                    'deposit' => $goalDeposit['deposit'],
                    'date' => $date
                ]);
            };
        }

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
        $request->validate([
            'name' => 'required|string',
            'end_goal' => 'required|numeric',
            'contribution' => 'required|numeric',
            'icon_id' => 'required|integer',
            'is_main_priority' => 'required|boolean',
            'saving_account_iban' => 'nullable|string',
        ]);

        $goal = Goal::find($budgetId);
        $goal->fill($request->all());
        $goal->save();

        $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
        $tagService = new TagService($tagRepository);
        if (!$request->saving_account_iban != null) {
            $tagService->applyTagsByIban($request->saving_account_iban, $goal->type_id);
        }
        event(new NotificationEvent('Budget items have been updated'));

        return to_route('goal.index');
    }


    public function destroy($goalId): void
    {
        $goal = Goal::find($goalId);
        if ($goal->saving_account_iban) {
            $tagRepository = app(TagRepositoryInterface::class, ['model' => new Expense(), 'availableTags' => new FilterTags()]);
            $tagService = new TagService($tagRepository);
            $tagService->removeTagsByIban($goal->saving_account_iban);
        }
        
        $budgetTypes = BudgetTypes::find($goal->type_id);
        if ($budgetTypes) {
            $budgetTypes->delete();
        }
        $goal->delete();
        event(new NotificationEvent('Budget item removed'));
    }

    // TODO absolute disaster, will need to revisit and refactor
    private function buildDetailTable($user): Collection
    {
        $table = [
            'thead' => [
                'Id',
                'Date',
                'Paid',
                'Progress'
            ]
        ];

        $goals = Goal::where('user_id', $user->id)->with('goal_deposit:id,goal_id,deposit,date')->select('id', 'contribution')->get()->map(function ($query) {
            foreach ($query->goal_deposit as $deposit) {
                $value[substr($deposit->date, 0, 7)][] = [
                    'goal_id' => $deposit->goal_id,
                    'deposit' => $deposit->deposit
                ];
                $query->filtered_data = $value;
            };
            return $query;
        });

        $i = 1;
        foreach ($goals as $goal) {

            if ($goal->goal_deposit->isEmpty()) {
                $table[$goal->id]['tbody'][] = [
                    1,
                    'No Data',
                    'No Data',
                    'No Data',
                ];
                continue;
            }

            foreach ($goal->filtered_data as $date => $deposit) {
                $table[$deposit[0]['goal_id']]['tbody'][] = [
                    $i++,
                    $date,
                    array_sum(array_column($deposit, 'deposit')) . ' / ' . $goal['contribution'],
                    'Nothing',
                ];
            }
        }
        return collect($table);
    }
}
