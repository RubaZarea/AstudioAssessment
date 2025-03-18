<?php

namespace App\Repositories;

use App\DTO\UserInput;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function index(): Collection
    {
        return User::all();
    }

    public function store(UserInput $userData): User
    {
        return User::create([
            'first_name' => $userData->firstName,
            'last_name' => $userData->lastName,
            'email' => $userData->email,
            'password' => Hash::make($userData->password),
        ]);
    }

    public function show($id): User
    {
        return User::findOrFail($id);
    }

    public function update(array $userData, int $id): User
    {
        $user = User::findOrFail($id);
        $user->update($userData);

        return $user;
    }

    public function destroy(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
