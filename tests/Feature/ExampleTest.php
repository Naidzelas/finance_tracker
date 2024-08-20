<?php

use inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
    Route::get('/', function () {
        Inertia::render('Home')->assertStatus(200);
    });
});

it('renders public pages', function (string $path, string $component) {

    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/',
        'component' => 'Home',
    ],
]);