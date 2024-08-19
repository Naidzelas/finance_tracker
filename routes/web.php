<?php

use App\Models\Budget\BudgetIcon;
use Illuminate\Support\Facades\Route;
use inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
