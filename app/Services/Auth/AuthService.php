<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user and issue an API token
     *
     * @param array $data
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        // Create user (password is automatically hashed via $casts in User model)
        $user = User::create($data);
        $user->syncRoles(['user']);
        // Create API token for the new user
        $token = $user->createToken('API Token')->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * Authenticate a user with email and password, then issue an API token
     *
     * @param string $email
     * @param string $password
     * @return array{user: User, token: string}
     *
     * @throws ValidationException
     */
    public function login(string $email, string $password): array
    {
        // Find user by email
        $user = User::where('email', $email)->first();

        // Validate password
        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        // Create API token for the authenticated user
        $token = $user->createToken('API Token')->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * Revoke tokens for a user
     *
     * @param User $user
     * @param string $type "current" | "all" | "specific"
     * @param int|null $tokenId
     * @return string
     */
    public function logout(User $user, string $type = 'current', ?int $tokenId = null): string
    {
        if ($type === 'all') {
            // Revoke all tokens
            $user->tokens()->delete();
            return 'All tokens revoked';
        } elseif ($type === 'specific' && $tokenId) {
            // Revoke a specific token by ID
            $user->tokens()->where('id', $tokenId)->delete();
            return "Token $tokenId revoked";
        }

        // Revoke only the token used for the current request
        $user->currentAccessToken()->delete();
        return 'Current token revoked';
    }
}
