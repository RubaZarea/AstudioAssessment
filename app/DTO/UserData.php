<?php

namespace App\DTO;

use App\Models\User;

class UserData
{
    public $user;
    public $accessToken;

    public function __construct(User $user, string $accessToken)
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
    }
}
