<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('app.url', 'http://localhost');
    app()->detectEnvironment(function () {
        return 'testing';
    });

    $this->withoutVite();
});

it('has required routes defined', function ($route) {
    expect(Route::has($route))->toBeTrue("Route {$route} is not defined");
})->with([
    'index',
    'debt.index',
    'debt.create',
    'debt.store',
    'debt.edit',
    'debt.update',
    'debt.destroy',
    'goal.index',
    'goal.create',
    'goal.store',
    'goal.edit',
    'goal.update',
    'goal.destroy',
    'investment.index',
    'investment.create',
    'investment.store',
    'investment.edit',
    'investment.update',
    'investment.destroy',
    'budget.index',
    'budget.create',
    'budget.store',
    'budget.edit',
    'budget.update',
    'budget.destroy',
    'expense_list.index',
    'expense_list.create',
    'expense_list.store',
    'expense_list.edit',
    'expense_list.update',
    'expense_list.destroy',
    'expense_list.fetch',
    'expense_list.fetchByType',
    'document.destroy',
    'document.download',
    'document.open',
    'profile.index',
    'profile.update',
    'profile.destroy',
    'profile.statistics',
    'introduction.index',
    'introduction.store',
    'login',
    'logout'
]);

it('redirects unauthenticated users to login page', function () {
    $protectedRoutes = [
        '/debt',
        '/goal',
        '/investment',
        '/budget',
        '/settings/profile'
    ];

    foreach ($protectedRoutes as $route) {
        $this->get($route)
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
});

it('redirects authenticated users to appropriate pages', function ($routeName, $component) {

    login($this)->get(route($routeName))->assertInertia(
        fn(Assert $page) => $page
            ->component($component)
    );
})->with([
    ['index', 'Home'],
    ['debt.index', 'Debt'],
    ['debt.create', 'Item'],
    ['goal.index', 'Goal'],
    ['goal.create', 'Item'],
    ['investment.index', 'Investment'],
    ['budget.create', 'Item'],
    ['expense_list.index', 'ExpenseList'],
    ['profile.index', 'Profile'],
    ['introduction.index', 'Introduction']

    // Has conditional return not always Inetia. Will look into later
    // ['goal.edit', 'Item'],
    // ['debt.edit', 'Item'],
    // ['investment.create', 'Item'],
    // ['investment.edit', 'Item'],
    // ['budget.index', 'Home'],
    // ['budget.edit', 'Item'],
]);
