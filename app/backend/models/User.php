<?php

namespace App\Backend\Models;

use Phalcon\Mvc\Model;

/**
 * @Source("users")
 */
class User extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected string $id;

    /**
     * @Column(type="string", nullable=false)
     */
    protected string $username;

    /**
     * @Column(type="string", nullable=false)
     */
    protected string $email;

    /**
     * @Column(type="string", nullable=false)
     */
    protected string $password;

    /**
     * @Column(type="string", nullable=false)
     */
    protected string $created_at;

    public function initialize()
    {
        $this->setSource('users'); // maps to MySQL 'users' table

        // One User has many Posts
        $this->hasMany(
            'id',
            Post::class,
            'user_id',
            [
                'alias' => 'Posts',
            ]
        );
    }

    // ID
    public function getId(): string
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
