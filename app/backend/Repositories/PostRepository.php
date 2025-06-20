<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Post;

class PostRepository
{
    public function getAllPosts()
    {
        return Post::find();
    }
}
