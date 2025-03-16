<?php

namespace App\Http\Controllers;

use App\DTO\UserInput;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authSvc;

    public function __construct(AuthService $authSvc)
    {
        $this->authSvc = $authSvc;
    }

    public function register(RegisterRequest $request)
    {
        $userInput = UserInput::fromRequest($request);
        $userData = $this->authSvc->register($userInput);

        return response()->json([
            'user' => $userData->user->only(['first_name', 'last_name', 'email']),
            'token' => $userData->accessToken
        ]);
    }
}
