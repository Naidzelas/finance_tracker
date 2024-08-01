<?php

use Illuminate\Support\Facades\Route;
use inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
