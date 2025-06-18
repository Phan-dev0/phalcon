<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $message = "Hello world!";
        echo "Hello";
    }
}