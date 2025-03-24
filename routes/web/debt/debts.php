<?php

use App\Http\Controllers\Debts\DebtController;
use App\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('/debt', DebtController::class)->only([
        'index',
        'create',
        'destroy',
        'edit',
        'load',
        'store',
        'update',
    ]);
});
