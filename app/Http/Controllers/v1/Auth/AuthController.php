<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\v1\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    // Dependency injection of AuthService
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'User registered successfully',
            'user' => new ProfileResource($result['user']),
            'token' => $result['token'],
        ], 201);
    }

    /**
     * Login existing user
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->email,
            $request->password
        );

        return response()->json([
            'message' => 'Login successful',
            'user' => $result['user'],
            'token' => $result['token'],
        ]);
    }

    /**
     * Logout user (current, all, or specific token)
     */
    public function logout(Request $request)
    {
        $message = $this->authService->logout(
            $request->user(),
            $request->input('type', 'current'),
            $request->input('token_id')
        );

        return response()->json(['message' => $message]);
    }
}
