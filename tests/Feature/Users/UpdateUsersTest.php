<?php

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\put;

test('user can update any user data', function () {
    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => '',
        'password_confirmation' => '',
    ];

    asUser()
        ->put(route('users.update', $user), $data)
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'Updated Successfully!');

    assertDatabaseHas(User::class, [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

test('password will be updated only if sent in request data', function () {
    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => 'new_password',
        'password_confirmation' => 'new_password',
    ];

    asUser()
        ->put(route('users.update', $user), $data)
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'Updated Successfully!');

    assertDatabaseHas(User::class, [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    expect(Hash::check('new_password', $user->fresh()->password))->toBeTrue();
});

test('guests can not update user data', function () {
    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => '',
        'password_confirmation' => '',
    ];

    put(route('users.update', $user), $data)
        ->assertRedirectToRoute('login');

    assertDatabaseMissing(User::class, [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

test('name and email are required to update user', function () {
    $user = User::factory()->create();

    asUser()
        ->put(route('users.update', $user), [])
        ->assertSessionHasErrors(['name', 'email']);

    assertDatabaseHas(User::class, Arr::only($user->toArray(), ['id', 'name', 'email']));
});
