<?php

use App\Http\Controllers\budget\BudgetTypesController;
use App\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('/budget', BudgetTypesController::class)->only([
        'index',
        'create',
        'destroy',
        'edit',
        'load',
        'store',
        'update',
    ]);
});
