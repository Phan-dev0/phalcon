<?php

namespace App\Frontend\Models;

use Phalcon\Mvc\Model;

class User extends Model
{
    protected int $id;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $created_at;

    public function initialize()
    {
        $this->setSource('users'); // maps to MySQL 'users' table
    }

    // ID
    public function getId(): int
    {
        return $this->id;
    }

    // Username
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Password
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    // Created At
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

}
