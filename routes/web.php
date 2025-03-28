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

// Debt
require __DIR__ . "/web/debt/debts.php";

// Document
require __DIR__ . "/web/document/document.php";

Route::get('/item', function () {
    return Inertia::render('Item');
});

Route::get('/landing', function () {
    return Inertia::render('Landing');
});

// Goals
require __DIR__ . "/web/goals/goals.php";

// Auth
require __DIR__.'/auth.php';

// Settings
require __DIR__.'/settings.php';
