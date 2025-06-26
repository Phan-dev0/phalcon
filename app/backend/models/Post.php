<?php

namespace App\Backend\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\StringLength;

/**
 * @Source("posts")
 */
class Post extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected ?string $id = null;

    /**
     * @Column(type="string", nullable=true)
     */
    protected ?string $user_id = null;

    /**
     * @Column(type="string", nullable=true)
     */
    protected string $title;

    /**
     * @Column(type="string", nullable=true)
     */
    protected string $content;

    /**
     * @Column(type="string", nullable=false)
     */
    protected ?string $created_at = null;

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

        // user_id must be present and numeric
        $validator->add(
            'user_id',
            new PresenceOf([
                'message' => "User is required"
            ])
        );

        // title must be present and between 1 and 255 characters
        $validator->add(
            'title',
            new StringLength([
                'max'            => 255,
                'min'            => 1,
                'messageMaximum' => 'Title cannot exceed 255 characters',
                'messageMinimum' => 'Title cannot be empty'
            ])
        );

        // content must be present and between 1 and  20000 characters
        $validator->add(
            'content',
            new StringLength([
                'min' => 1,
                'max' => 20000,
                'messageMaximum' => 'Content cannot exceed 20000 characters',
                'messageMinimum' => 'Content cannot be empty'
            ])
        );

        return $this->validate($validator);
    }

    // public function getCreatedAtFormatted()
    // {
    //     return date('d/m/Y', strtotime($this->created_at));
    // }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    // Setters
    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
