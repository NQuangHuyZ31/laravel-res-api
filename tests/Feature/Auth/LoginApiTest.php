<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;



test('can login', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password'=> Hash::make('123456'),
    ]);

    $response = $this->postJson('/api/login', [
        'email'=> 'test@example.com',
        'password'=> '123456',
    ]);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'user' => [
            'id', 'name', 'email'
        ],
        'token'
    ])
    ->assertJson([
        'user' => [
            'id' => $user->id,
            'name'=> $user->name,
            'email' => $user->email
        ]
    ]);

    expect($response->json('token'))->not->toBeEmpty();

    $this->assertAuthenticated();
});

test('login fail email required', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password'=> Hash::make('123456'),
    ]);

    $response = $this->postJson('/api/login', [
        'password'=> '123456',
    ]);

    $response->assertStatus(422)
    ->assertJsonValidationErrors(['email']);

    $this->assertGuest();
});

test('login fail passworđ required', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password'=> Hash::make('123456'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com'
    ]);

    $response->assertStatus(422)
    ->assertJsonValidationErrors(['password']);

    $this->assertGuest();
});

// test('login fail many request', function () {
//     $user = User::factory()->create([
//         'email' => 'test@example.com',
//         'password'=> Hash::make('123456'),
//     ]);

//     for ($i = 0; $i < 5; $i++) {
//         $this->postJson('/api/login', [
//             'email' => 'test@example.com',
//             'password' => '123456'
//         ]);
//     }

//     $response = $this->postJson('/api/login', [
//         'email' => 'test@example.com',
//         'password' => '123456'
//     ]);

//     $response->assertStatus(422)
//     ->assertJsonValidationErrors(['email']);

//     $this->assertGuest();
// });
