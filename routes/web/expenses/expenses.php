<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use inertia\Inertia;

// Route::group(["prefix"=> "/goal"], function () {
//     Route::get("/item", [GoalController::class,
// });

Route::resource('/', ExpenseController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);