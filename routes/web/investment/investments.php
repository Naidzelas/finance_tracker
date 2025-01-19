<?php

use App\Http\Controllers\investment\InvestmentController;
use Illuminate\Support\Facades\Route;

Route::resource('/investment', InvestmentController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);