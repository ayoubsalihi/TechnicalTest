<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('permet à un utilisateur de s\'inscrire', function () {
    Storage::fake('public');
    
    $response = $this->postJson('/api/auth/register', [
        'full_name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'phone' => '1234567890',
        'address' => '123 Test Street',
        'image' => UploadedFile::fake()->image('avatar.jpg'),
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => ['id', 'full_name', 'email'],
            'token'
        ]);
});

it('bloque l\'inscription avec des données invalides', function () {
    $response = $this->postJson('/api/auth/register', [
        'full_name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['full_name', 'email', 'password']);
});

it('permet à un utilisateur de se connecter', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password')
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);
});

it('bloque la connexion avec des identifiants invalides', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson(['error' => 'Unauthorized']);
});
