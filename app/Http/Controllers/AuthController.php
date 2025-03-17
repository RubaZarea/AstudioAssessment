<?php

namespace App\Http\Controllers;

use App\DTO\UserInput;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

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
            'user' => $userData->user,
            'token' => $userData->accessToken
        ]);
    }

    public function login(Request $request)
    {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $userData = $this->authSvc->login($credentials);

            return response()->json([
                'user' => $userData->user,
                'token' => $userData->accessToken
            ]);
        } catch (UnauthorizedException) {
            return response()->json(['error' => 'Invalid login details'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authSvc->logout($request->user());
            
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (UnauthorizedException) {
            return response()->json(['message' => 'Logged out failed'], 401);
        }
    }
}
