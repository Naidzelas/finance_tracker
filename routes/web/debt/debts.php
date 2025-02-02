<?php

use App\Http\Controllers\Debts\DebtController;
use Illuminate\Support\Facades\Route;

Route::resource('/debt', DebtController::class)->only([
    'index',
    'create',
    'destroy',
    'edit',
    'load',
    'store',
    'update',
]);