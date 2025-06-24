<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Post;

class PostRepository
{
    // Get all posts
    public function getAllPosts()
    {
        return Post::find();
    }

    public function getPostById(int $id)
    {
        $post = Post::findFirstById($id);
        if (!$post) {
            return false;
        }
        return $post;
    }

    public function create(Post $post)
    {
        if (!$post->save()) {
            return false;
        }
        return true;
    }

    public function update(Post $post)
    {
        if (!$post->save()) {
            return false;
        }
        return true;
    }

    public function delete(Post $post)
    {
        if (!$post->delete()) {
            return false;
        }
        return true;
    }

}
