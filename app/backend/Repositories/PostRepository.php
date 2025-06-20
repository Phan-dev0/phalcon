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

    // Get post by ID
    public function getPostById(int $id)
    {
        $post = Post::findFirstById($id);
        if (!$post) {
            return null; // Not found
        }
        return $post;
    }

    // Create new post
    public function create(array $data)
    {
        $post = new Post();
        $post->setUserId($data['user_id']);
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        if (!$post->save()) {
            return $post->getMessages();
        }

        return true; 
    }

    // Update existing post
    public function update(int $id, array $data)
    {
        $post = Post::findFirstById($id);
        if (!$post) {
            return ['error' => 'Post not found'];
        }

        if (isset($data['title'])) {
            $post->setTitle($data['title']);
        }
        if (isset($data['content'])) {
            $post->setContent($data['content']);
        }

        if (!$post->save()) {
            return $post->getMessages();
        }

        return true; 
    }

    // Delete post
    public function delete(int $id)
    {
        $post = Post::findFirstById($id);
        if (!$post) {
            return ['error' => 'Post not found'];
        }

        if (!$post->delete()) {
            return $post->getMessages();
        }

        return true; 
    }
}
