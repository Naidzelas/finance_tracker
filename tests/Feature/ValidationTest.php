<?php

use App\Models\Budget\BudgetTypes;
use App\Models\Debts\Debt;
use App\Models\Goals\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    app()->detectEnvironment(function () {
        return 'testing';
    });
});

it('validates required fields when creating a debt record', function ($field) {

    $response = $this->from('http://localhost/debt/create')
        ->post(route('debt.store'), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect('http://localhost/debt/create');
})->with([
    'name',
    'iconify_name',
    'loan_size',
    'monthly_payment',
    'loan_final_amount',
    'interest_rate',
    'payment_date',
    'loan_end_date'
]);

it('validates required fields when editing a debt record', function ($field) {
    $debt = Debt::factory()->create();
    
    $response = $this->from(route('debt.edit', $debt->id))
        ->put(route('debt.update', $debt->id), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect(route('debt.edit', $debt->id));
})->with([
    'name',
    'iconify_name',
    'loan_size',
    'monthly_payment',
    'loan_final_amount',
    'interest_rate',
    'payment_date',
    'loan_end_date'
]);

// TODO uncomment when the investment feature is refacotred

// it('validates required fields when creating an investment record', function ($field) {
//     $response = $this->from('http://localhost/investment/create')
//         ->post(route('investment.store'), []);

//     $response->assertSessionHasErrors($field);
//     $response->assertRedirect('http://localhost/investment/create');
// })->with([
//     'symbol',
//     'invested',
//     'value',
//     'investment_type_id',
//     'iconify_name',
// ]);

it('validates required fields when creating a budget record', function ($field) {
    $response = $this->from('http://localhost/budget/create')
        ->post(route('budget.store'), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect('http://localhost/budget/create');
})->with([
    'name',
    'amount',
    'iconify_name',
]);

it('validates required fields when editing a budget record', function ($field) {
    $budget = BudgetTypes::factory()->create();

    $response = $this->from(route('budget.edit', $budget->id))
        ->put(route('budget.update', $budget->id), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect(route('budget.edit', $budget->id));
})->with([
    'name',
    'amount',
    'iconify_name',
]);

it('validates required fields when creating a goal record', function ($field) {
    $response = $this->from('http://localhost/goal/create')
        ->post(route('goal.store'), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect('http://localhost/goal/create');
})->with([
    'name',
    'end_goal',
    'contribution',
    'iconify_name',
    'is_main_priority',
]);

it('validates required fields when editing a goal record', function ($field) {
    $goal = Goal::factory()->create();

    $response = $this->from(route('goal.edit', $goal->id))
        ->put(route('goal.update', $goal->id), []);

    $response->assertSessionHasErrors($field);
    $response->assertRedirect(route('goal.edit', $goal->id));
})->with([
    'name',
    'end_goal',
    'contribution',
    'iconify_name',
    'is_main_priority',
]);
