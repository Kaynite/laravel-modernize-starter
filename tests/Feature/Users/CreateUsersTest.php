<?php

use App\Models\User;
use Illuminate\Support\Arr;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('user can view a form to create another user', function () {
    asUser()
        ->get(route('users.create'))
        ->assertOk();
});

test('guests can not view user creation form', function () {
    get(route('users.create'))
        ->assertRedirectToRoute('login');
});

test('user can create another user', function () {
    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => $password = fake()->password(),
        'password_confirmation' => $password,
    ];

    asUser()
        ->post(route('users.store'), $data)
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'Created Successfully!');

    assertDatabaseHas(User::class, Arr::only($data, ['name', 'email']));
});

test('name, email and password are required to create new user', function () {
    asUser()
        ->post(route('users.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'password']);

    expect(User::count())->toBeOne(); // The one created in `asUser` function
});

test('email must be a valid email to create new user', function ($invalidEmail) {
    $data = [
        'name' => fake()->name(),
        'email' => $invalidEmail,
        'password' => $password = fake()->password(),
        'password_confirmation' => $password,
    ];

    asUser()
        ->post(route('users.store'), $data)
        ->assertSessionHasErrors(['email']);

    expect(User::count())->toBeOne();
})->with(['test', 123, true, false, ['array']]);

test('password must be confirmed to create new user', function ($password, $password_confirmation) {
    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => $password,
        'password_confirmation' => $password_confirmation,
    ];

    asUser()
        ->post(route('users.store'), $data)
        ->assertSessionHasErrors(['password']);

    expect(User::count())->toBeOne();
})->with([
    'password not confirmed' => ['password' => 'password', 'password_confirmation' => ''],
    'password confirmation wrong' => ['password' => 'password', 'password_confirmation' => 'another password'],
]);

test('guests can not store new users', function () {
    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => $password = fake()->password(),
        'password_confirmation' => $password,
    ];

    post(route('users.store'), $data)
        ->assertRedirectToRoute('login');

    assertDatabaseMissing(User::class, Arr::only($data, ['name', 'email']));
});
