<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    RegisterRequest,
    LoginRequest
};
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());
        
        return $result
            ? response()->json($result)
            : response()->json(['error' => 'Unauthorized'], 401);
    }
}