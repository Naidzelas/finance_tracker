<?php

use Illuminate\Support\Facades\Route;
use inertia\Inertia;

// Expenses
require __DIR__ . "/web/expenses/expenses.php";
require __DIR__ . "/web/expenses/expenseList.php";

// Budget
require __DIR__ . "/web/budget/budgetTypes.php";

// Investment
require __DIR__ . "/web/investment/investments.php";

Route::get('/debt', function () {
    return Inertia::render('Debt');
});

Route::get('/item', function () {
    return Inertia::render('Item');
});

// Goals
include __DIR__ . "/web/goals/goals.php";