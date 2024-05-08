<?php

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Database\Eloquent\Relations\HasOne;

uses(\Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users have config', function () {
    $user = User::factory()->create();

    expect($user->config())->toBeInstanceOf(HasOne::class);
    expect($user->config)->toBeInstanceOf(UserConfig::class);
});
