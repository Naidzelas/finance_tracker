<?php

use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;

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

    $goals = Goal::query()->withSum('goal_deposit as deposit','deposit')->get()->toArray();

    dump($goals);
    // return $goals;F
}
