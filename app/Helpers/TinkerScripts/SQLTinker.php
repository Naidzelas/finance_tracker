<?php

use App\Models\Goals\Goal;

function run()
{
    $table = [
        'thead' => [
            'Id',
            'Date',
            'Paid',
            'Progress'
        ],
        'tbody' => []
    ];

    $goals = Goal::query()->with(['goal_deposit' => fn($query) =>
        $query->selectRaw('goal_id, SUM(deposit) as deposit, concat(year(updated_at), "/",  month(updated_at)) as date')
            ->groupByRaw('goal_id, concat(year(updated_at), "/",  month(updated_at))')])->select('deposit')->get()->toArray();

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

    dump($table);
    // return $goals;
}
