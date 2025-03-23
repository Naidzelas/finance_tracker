<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('/', ExpenseController::class)->only([
        'index',
        'create',
        'destroy',
        'edit',
        'load',
        'store',
        'update',
    ]);
});
