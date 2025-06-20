<?php
namespace App\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{
    public function notFoundAction()
    {
        echo '404';
    }
}
