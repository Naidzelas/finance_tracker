<?php

use inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\get;

it('returns a successful response for home page', function () {
    Route::get('/', function () {
        Inertia::render('Home')->assertStatus(200);
    });
});

it('returns a successful response for debt page', function () {
    Route::get('/debt', function () {
        Inertia::render('Debt')->assertStatus(200);
    });
});

it('returns a successful response for goal page', function () {
    Route::get('/goal', function () {
        Inertia::render('Goal')->assertStatus(200);
    });
});

it('returns a successful response for investment page', function () {
    Route::get('/investment', function () {
        Inertia::render('Investment')->assertStatus(200);
    });
});

it('returns a successful response for item page', function () {
    Route::get('/item', function () {
        Inertia::render('Item')->assertStatus(200);
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

it('tests', function(){
    // $this->withoutExceptionHandling();
    $this->get(route('index'))->assertOk();
});