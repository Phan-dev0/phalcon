<?php

namespace App\Backend\Models;

use Phalcon\Mvc\Model;

class Post extends Model
{
    protected int $id;
    protected int $user_id;
    protected string $title;
    protected string $content;
    protected string $created_at;

    public function initialize()
    {
        $this->setSource('posts');

        // Define relationship: Many Posts belong to one User
        $this->belongsTo(
            'user_id',
            User::class,
            'id',
            [
                'alias' => 'User',
            ]
        );
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): string { return $this->created_at; }

    // Setters
    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setContent(string $content): void { $this->content = $content; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
}
