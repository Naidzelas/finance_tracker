<?php

use Illuminate\Support\Facades\Route;

use App\Http\Requests\AuthKitAuthenticationRequest;
use App\Http\Requests\AuthKitLoginRequest;
use App\Http\Requests\AuthKitLogoutRequest;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    return tap(to_route('index'), fn () => $request->authenticate());
})->middleware(['guest']);

Route::post('logout', function (AuthKitLogoutRequest $request) {
    return $request->logout();
})->middleware(['auth'])->name('logout');