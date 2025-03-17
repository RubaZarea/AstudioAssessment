<?php

namespace App\Services;

use App\DTO\UserData;
use App\DTO\UserInput;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class AuthService
{
    private $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(UserInput $userInput): UserData
    {
        $user = $this->authRepo->register($userInput);
        $accessToken = $user->createToken('api_token')->accessToken;

        return new UserData($user, $accessToken);
    }

    public function login(array $credentials): UserData
    {
        throw_unless(Auth::attempt($credentials), UnauthorizedException::class, 'Unauthorized');
        $user = Auth::user();
        $accessToken = $user->createToken('api_token')->accessToken;

        return new UserData($user, $accessToken);
    }

    public function logout($user): void
    {
        throw_unless(Auth::user(), UnauthorizedException::class, 'Unauthorized');
        $user->token()->revoke();
    }
}
