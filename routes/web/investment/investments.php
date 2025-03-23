<?php

use App\Http\Controllers\investment\InvestmentController;
use App\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('/investment', InvestmentController::class)->only([
        'index',
        'create',
        'destroy',
        'edit',
        'load',
        'store',
        'update',
    ]);
});
