<?php

namespace App\Backend\Controllers;

use Phalcon\Mvc\Controller;
use App\Backend\Repositories\PostRepository;


class IndexController extends Controller
{
    public function indexAction()
    {
        $postRepo = new PostRepository();

        $this->view->posts = $postRepo->getAllPosts();

    }
}
