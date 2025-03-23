<?php

use App\Http\Controllers\Goals\GoalController;
use App\Http\Middleware\ValidateSessionWithWorkOS;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('/goal', GoalController::class)->only([
        'index',
        'create',
        'destroy',
        'edit',
        'load',
        'store',
        'update',
    ]);
});
