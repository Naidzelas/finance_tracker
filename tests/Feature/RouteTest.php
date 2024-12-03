<?php

use Inertia\Testing\AssertableInertia as Assert;

// HOME
it('returns a successful response for home page', function (string $path, string $component) {
    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/',
        'component' => 'Home',
    ],
]);

// DEBT
it('returns a successful response for debt page', function (string $path, string $component) {
    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/debt',
        'component' => 'Debt',
    ],
]);

// GOAL
it('returns a successful response for goal page', function (string $path, string $component) {
    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/goal',
        'component' => 'Goal',
    ],
]);

// INVESTMENT
it('returns a successful response for investment page', function (string $path, string $component) {
    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/investment',
        'component' => 'Investment',
    ],
]);

// ITEM
it('returns a successful response for item page', function (string $path, string $component) {
    $this->get($path)
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component($component));

})->with([
    [
        'path' => '/item',
        'component' => 'Item',
    ],
]);