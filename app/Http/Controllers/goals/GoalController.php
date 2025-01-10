<?php

namespace App\Http\Controllers\Goals;

use App\Http\Controllers\Controller;
use App\Models\Goals\Goal;
use App\Models\Icons;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index()
    {
        return Inertia::render('Goal', [
            'goals' => Goal::query()->with([
                    'goal_deposit' => fn($query) => $query->selectRaw('goal_id, SUM(deposit) as deposit')
                        ->groupBy('goal_id')->get(),
                    'icon'
                ])
                ->get(),
            'detailsTab' => [
                'table' => self::buildDetailTable(),
                'documents' => '',
                'notes' => ''
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Item', [
            'registerRoute' => 'goal',
            'method' => 'post',
            'list' => [
                'name' => ['String',],
                'goal_deposit_id' =>  ['Number',],
                'end_goal' => ['Number',],
                'contribution' => ['Number',],
                'icon_id' => ['Select',],
                'is_main_priority' => ['Boolean',],
                'is_active' => ['Boolean',],
                'date' => ['Date',],
            ],
            'icons' => Icons::query()->get()->toArray(),
        ]);
    }

    public function store(Request $request, Goal $goal)
    {
        $goal->fill($request->all());
        $goal->save();
        return to_route('goal.index');
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
                ->groupByRaw('goal_id, concat(year(updated_at), "/",  month(updated_at))')])->get()->toArray();
    
        $i = 1;
        foreach ($goals as $goal) {
            foreach($goal['goal_deposit'] as $deposit){
                $table[$goal['id']]['tbody'][] = [
                    'Nr' => $i++,
                    'Date' => $deposit['date'],
                    'Paid' => $deposit['deposit'] . ' / ' . $goal['contribution'],
                    'Progress' => 'Nothing'
                ];
            }
        }

        return collect($table);
    }
}
