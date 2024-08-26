<?php

use Illuminate\Support\Facades\Route;
use inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/debt', function () {
    return Inertia::render('Debt');
});
Route::get('/investment', function () {
    return Inertia::render('Investment');
});

Route::get('/item', function () {
    return Inertia::render('Item');
});
// Goals
include __DIR__ . "/web/goals/goals.php";