<?php

namespace App\Services;

use App\DTO\UserData;
use App\DTO\UserInput;
use App\Repositories\AuthRepository;

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
}
