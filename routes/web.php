<?php

use App\Models\Budget\BudgetIcon;
use Illuminate\Support\Facades\Route;
use inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/debts', function () {
    return Inertia::render('Debt');
});
Route::get('/investments', function () {
    return Inertia::render('Investment');
});
Route::get('/goals', function () {
    return Inertia::render('Goal');
});
