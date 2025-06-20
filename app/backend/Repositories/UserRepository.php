<?php

namespace App\Backend\Repositories;

use App\Backend\Models\User;

class UserRepository
{
    public function getAllUsers()
    {
        return User::find();
    }
}
