<?php

use App\Http\Controllers\Debts\DebtController;
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

// This one currently not working
it('validates required fields when editing a debt record', function ($field) {

    $response = $this->from()
        ->post(route('debt.edit'), [1]);

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

// it('validates required fields when updating a profile', function ($field) {
//     $response = $this->from('http://localhost/settings/profile')
//         ->patch(route('profile.update'), []);

//     $response->assertSessionHasErrors($field);
//     $response->assertRedirect('http://localhost/');
// })->with([
//     'etoro_name',
//     'income',
// ]);
