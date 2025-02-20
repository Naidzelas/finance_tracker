<?php

use App\Http\Controllers\ExpenseListController;
use Illuminate\Support\Facades\Route;
use inertia\Inertia;


Route::resource('/expense_list', ExpenseListController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);

Route::get('/expense_list/{container}/{year_month}', [ExpenseListController::class, 'fetch'])->name('expense_list.fetch');
Route::get('/expense_list/filter/{container}/{budget_types}', [ExpenseListController::class, 'fetchByType'])->name('expense_list.fetchByType');
