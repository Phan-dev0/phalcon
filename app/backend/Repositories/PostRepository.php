<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Post;

class PostRepository
{
    // Get all posts
    public function filterPost(array $filters = [])
    {
        $conditions = [];
        $bind = [];

        // Filter by user_id
        if (!empty($filters['user_id'])) {
            echo 1;
            $conditions[] = 'user_id = :user_id:';
            $bind['user_id'] = $filters['user_id'];
        }

        // Filter by title (LIKE %title%)
        if (!empty($filters['title'])) {
            echo 2;
            $conditions[] = 'title LIKE :title:';
            $bind['title'] = '%' . $filters['title'] . '%';
        }

        // Filter by created_at >= from_date
        if (!empty($filters['from_date'])) {
            $conditions[] = 'created_at >= :from_date:';
            $bind['from_date'] = $filters['from_date'] . ' 00:00:00';
        }

        // Filter by created_at <= to_date
        if (!empty($filters['to_date'])) {
            $conditions[] = 'created_at <= :to_date:';
            $bind['to_date'] = $filters['to_date'] . ' 23:59:59';
        }

        $parameters = [];
        if (!empty($conditions)) {
            $parameters['conditions'] = implode(' AND ', $conditions);
            $parameters['bind'] = $bind;
        }

        return Post::find($parameters);
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
