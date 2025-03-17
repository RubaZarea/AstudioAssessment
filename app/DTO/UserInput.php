<?php

namespace App\DTO;

use Illuminate\Http\Request;

class UserInput
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public static function fromRequest(Request $request)
    {
        $inputs = new self();
        $inputs->firstName = $request->first_name;
        $inputs->lastName = $request->last_name;
        $inputs->email = $request->email;
        $inputs->password = $request->password;

        return $inputs;
    }
}
