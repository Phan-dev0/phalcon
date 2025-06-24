<?php

namespace App\Backend\Controllers;

date_default_timezone_set('Asia/Ho_Chi_Minh');

use Phalcon\Mvc\Controller;
use App\Backend\Repositories\PostRepository;
use App\Backend\Models\Post;
use App\Backend\Models\User;
use Phalcon\Mvc\Model\ResultsetInterface;


class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->posts = Post::find();
    }
    public function createAction()
    {
        $this->view->users = User::find();
        if ($this->request->isPost()) {
            $post = new Post();

            $post->assign([
                'user_id' => $this->request->getPost('user_id', 'string'),
                'title' => $this->request->getPost('title', 'string'),
                'content' => $this->request->getPost('content', 'string'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if (!$post->save()) {
                // die('<pre>' . print_r($post->getMessages(), true) . '</pre>');
                $this->view->setVar('errors', $post->getMessages());
                return;
            }
            $this->flashSession->success("A post created successfully");
            return $this->response->redirect('/admin');
        }
    }

    public function deleteAction()
    {
        $postId = $this->dispatcher->getParam('id', 'int');

        $post = Post::findFirstById($postId);

        if (!$post) {
            $this->flashSession->error("Invalid Post ID.");
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index'
            ]);
        }

        if (!$post->delete()) {
            $this->flashSession->error("Failed to delete post.");
        }

        $this->flashSession->success("Post deleted successfully.");

        return $this->dispatcher->forward([
            'controller' => 'index',
            'action'     => 'index'
        ]);
    }

    public function updateAction()
    {
        $postId = $this->dispatcher->getParam('id', 'int');

        $post = Post::findFirstById($postId);

        if (!$post) {
            $this->flashSession->error("Invalid Post ID.");
            return $this->response->redirect('/admin');
        }
        // var_dump($post->getTitle());

        $this->view->users = User::find();
        $this->view->post = $post;

        if ($this->request->isPost()) {
            $userId = $this->request->getPost('user_id');
            if ($userId === '' || $userId === null) {
                $userId = null;
            }

            $post->assign([
                'user_id'    => $userId,
                'title'      => $this->request->getPost('title', 'string') ?? "",
                'content'    => $this->request->getPost('content', 'string') ?? "",
                'created_at' => $post->created_at // Keep original created_at
            ]);

            if (!$post->save()) {
                $this->view->setVar('errors', $post->getMessages());
                return;
            }

            $this->flashSession->success("Post updated successfully.");

            return $this->response->redirect('/admin');
        }
    }
}
