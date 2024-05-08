<?php

use function Pest\Laravel\get;

test('user can view list of users', function () {
    asUser()
        ->get(route('users.index'))
        ->assertOk();
});

test('guests can not view the list of users', function () {
    get(route('users.index'))
        ->assertRedirectToRoute('login');
});
