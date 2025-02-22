<?php

use App\Http\Controllers\budget\BudgetTypesController;
use Illuminate\Support\Facades\Route;

Route::resource('/budget', BudgetTypesController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);
