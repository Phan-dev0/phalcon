<?php

namespace App\Backend\Controllers;

use Phalcon\Mvc\Controller;
use App\Backend\Repositories\UserRepository;
use App\Backend\Repositories\PostRepository;


class IndexController extends Controller
{
    public function indexAction()
    {
        $userRepo = new UserRepository();
        $postRepo = new PostRepository();

        $this->view->users = $userRepo->getAllUsers();
        $this->view->posts = $postRepo->getAllPosts();

    }
}
