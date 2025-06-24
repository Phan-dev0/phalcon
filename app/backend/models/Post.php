<?php

namespace App\Backend\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Numericality;




class Post extends Model
{
    protected ?int $id = null;
    protected ?string $user_id = null;
    protected ?string $title = null;
    protected ?string $content = null;
    protected string $created_at;

    public function initialize()
    {
        $this->setSource('posts');

        $this->belongsTo(
            'user_id',
            User::class,
            'id',
            [
                'alias' => 'User',
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();


        $validator->add(
            'user_id',
             new PresenceOf([
                'message' => "User is required"
            ])
        );

        $validator->add(
            'title',
            new PresenceOf([
                'message' => 'Title is required'
            ])
        );

        $validator->add(
            'content',
            new PresenceOf([
                'message' => 'Content is required'
            ])
        );

        return $this->validate($validator);
    }


    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): ?string
    {
        return $this->user_id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    // Setters
    public function setUserId(?string $user_id): void
    {
        $this->user_id = $user_id;
    }
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
