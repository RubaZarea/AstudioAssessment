<?php

namespace App\Services;

use App\DTO\UserInput;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(): Collection
    {
        return $this->userRepo->index();
    }

    public function store(UserInput $userData): User
    {
        return $this->userRepo->store($userData);
    }

    public function show(int $id): User
    {
        return $this->userRepo->show($id);
    }

    public function update(array $userData, int $id): User
    {
        return $this->userRepo->update($userData, $id);
    }

    public function destroy(int $id): void
    {
        $this->userRepo->destroy($id);
    }
}
