<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hash password in service layer
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $this->formatUser($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * Login a user
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    /**
     * Create a refresh token for the user
     *
     * @param User $user
     * @return string
     */
    protected function createRefreshToken(User $user): string
    {
        return $user->createToken(
            'refresh_token',
            ['*'],
            now()->addDays(30) // Refresh token expires in 30 days
        )->plainTextToken;
    }

    public function login(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoke existing tokens
        $this->userRepository->revokeTokens($user);

        // Create access token (expires in 1 hour by default)
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        // Create refresh token (expires in 30 days)
        $refreshToken = $this->createRefreshToken($user);

        return [
            'user' => $this->formatUser($user),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600, // 1 hour in seconds
        ];
    }

    /**
     * Logout a user
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $this->userRepository->revokeTokens($user);
    }

    /**
     * Refresh user token
     *
     * @param User $user
     * @return array
     */
    public function refreshToken(User $user): array
    {
        // Get the current token
        $currentToken = $user->currentAccessToken();

        // If it's a refresh token, revoke it after use
        if ($currentToken && $currentToken->name === 'refresh_token') {
            $user->tokens()->where('id', $currentToken->id)->delete();
        }

        // Create new access token
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        // Create new refresh token
        $refreshToken = $this->createRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600, // 1 hour in seconds
        ];
    }

    /**
     * Format user data for response
     *
     * @param User $user
     * @return array
     */
    public function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ];
    }
}
