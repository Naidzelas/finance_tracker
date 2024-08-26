<?php

use App\Http\Controllers\GoalController;
use Illuminate\Support\Facades\Route;

// Route::group(["prefix"=> "/goal"], function () {
//     Route::get("/item", [GoalController::class,
// });

Route::resource('/goal', GoalController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);