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