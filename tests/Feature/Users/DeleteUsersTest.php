<?php

use App\Models\User;
use Illuminate\Support\Arr;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;

test('user can delete another user', function () {
    $user = User::factory()->create();

    asUser()
        ->delete(route('users.destroy', $user))
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'Deleted Successfully!');

    assertDatabaseMissing(User::class, Arr::only($user->toArray(), ['id', 'name', 'email']));
});

test('guests can not delete users', function () {
    $user = User::factory()->create();

    delete(route('users.destroy', $user))
        ->assertRedirectToRoute('login');
});
