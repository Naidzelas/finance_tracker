<?php

namespace App\Http\Controllers;

use App\Models\Goals\Goal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GoalController extends Controller
{
    public function index()
    {
        return Inertia::render('Goal');
    }

   public function create()
   {
        Goal::create(['name'=> 'draft', 'goal_deposit_id' => 1]);
        return Inertia::render('Item',[
            'registerRoute' => 'goal',
            'list' => [
                'name'=> 'String',
                'goal_deposit_id'=>  'Integer',
                'icon_id' => 'Boolean',
                'is_main_priority' =>'Boolean',
                'date' => 'Date',
            ],
        ]);
   }

   public function store(Request $request, Goal $goal){
    dd($request->all());
        $goal->fill($request->all());
        $goal->save();
        return to_route('goal.index');
   }

   
}
