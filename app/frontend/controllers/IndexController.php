<?php
namespace App\Frontend\Controllers;

use Phalcon\Mvc\Controller;

/**
 * @RoutePrefix("/")
 */
class IndexController extends Controller
{
    /**
     * @Get(
     *     '/'
     * )
     */
    public function indexAction()
    {
    }
}
