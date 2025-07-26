<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        $token = JWTAuth::fromUser($user);
        
        return compact('user', 'token');
    }

    public function login(array $credentials): ?array
    {
        if (!$token = auth()->attempt($credentials)) {
            return null;
        }
        
        return [
            'token' => $token,
            'user' => auth()->user()
        ];
    }
}