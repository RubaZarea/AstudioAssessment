<?php

namespace App\Repositories;

use App\DTO\UserInput;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{

    public function register(UserInput $userInput): User
    {
        return User::create([
            'first_name' => $userInput->firstName,
            'last_name' => $userInput->lastName,
            'email' => $userInput->email,
            'password' => Hash::make($userInput->password)
        ]);
    }
}
