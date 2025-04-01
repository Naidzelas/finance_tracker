<?php

namespace App\Http\Controllers;

use App\Models\Budget\BudgetTypes;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IntroductionController extends Controller
{
    /**
     * Display the introduction page
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Introduction');
    }

    /**
     * Store budget types from introduction form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'income' => 'numeric|min:0',
            'budgetItems' => 'array',
            'budgetItems.*.name' => 'string|max:255',
            'budgetItems.*.amount' => 'numeric|min:0',
        ]);

        foreach ($validatedData['budgetItems'] as $item) {
            BudgetTypes::create([
                'user_id' => $request->user()->id,
                'name' => $item['name'],
                'amount' => $item['amount'],
                'iconify_name' => 'tabler:apps-filled'
            ]);
        }
        User::where('id', $request->user()->id)
            ->update([
                'new_user' => false, 
                'income' => $validatedData['income']
            ]);

        return to_route('index');
    }
}