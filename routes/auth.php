<?php

use Illuminate\Support\Facades\Route;

use App\Http\Requests\AuthKitAuthenticationRequest;
use App\Http\Requests\AuthKitLoginRequest;
use App\Http\Requests\AuthKitLogoutRequest;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    $request->authenticate();

    return match ((bool) $request->user()->new_user) {
        true => to_route('introduction.index'),
        false => to_route('index'),
    };
});

Route::post('logout', function (AuthKitLogoutRequest $request) {
    return $request->logout();
})->name('logout');
