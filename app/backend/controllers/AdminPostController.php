<?php

namespace App\Backend\Controllers;

use Phalcon\Mvc\Controller;
use App\Backend\Repositories\PostRepository;
use App\Backend\Models\Post;
use App\Backend\Models\Test;
use App\Backend\Forms\PostFilterForm;
use App\Backend\Forms\CreateAndUpdatePostForm;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

/**
 * @RoutePrefix("/admin")
 */
class AdminPostController extends Controller
{
    /**
     * @Route("/", name="adminpost-index", methods={"GET"})
     */
    public function indexAction()
    {
        // Get query params from URL 
        $filters = [
            'user_id'   => $this->request->getQuery('user_id', 'string', ''),
            'title'     => $this->request->getQuery('title', 'string', ''),
            'from_date' => $this->request->getQuery('from_date', 'string', ''),
            'to_date'   => $this->request->getQuery('to_date', 'string', ''),
        ];

        $postRepo = new PostRepository();
        $posts = $postRepo->filterPost($filters);

        // Create form
        $form = new PostFilterForm();
        $form->bind($filters, null);

        // Set data for the view
        $this->view->setVars([
            'form'             => $form,
            'posts'            => $posts,
        ]);

        $this->view->pick('adminPost/index');
    }


    /**
     * @Route("/post/create", name="adminpost-create",methods={"GET"})
     */
    public function showCreatePageAction()
    {
        $filters = [
            'title'     => $this->request->getPost('title', 'string', ''),
            'content'     => $this->request->getPost('content', 'string', ''),
        ];

        //create create form
        $form = new CreateAndUpdatePostForm();
        $form->bind($filters);

        $this->view->setVars([
            'form' => $form
        ]);

        $this->view->pick('adminPost/create');
    }

    /**
     * @Route("/post/create", name="adminpost-create-post",methods={"POST"})
     */
    public function createAction()
    {
        if (!$this->security->checkToken()) {
            echo "block";
            exit;
        }

        try {
            $manager = new Manager();
            $transaction = $manager->get();

            $post = new Post();

            $post->setTransaction($transaction);

            $post->assign([
                'user_id'    => $this->request->getPost('user_id', 'string'),
                'title'      => $this->request->getPost('title', 'string'),
                'content'    => $this->request->getPost('content', 'string'),
            ]);

            if (!$post->save()) {
                $this->view->setVar('errors', $post->getMessages());
                $transaction->rollback("Can't save post");
                return;
            }

            $test = new Test();
            $test->assign([
                'name' => "ok"
            ]);

            $test->setTransaction($transaction);

            if (!$test->save()) {
                $transaction->rollback("Can't save test");
                return;
            }

            $transaction->commit();
            $this->flashSession->success("A post created successfully");
            return $this->response->redirect('/admin');
        } catch (Failed $e) {
            error_log("Failed, reason: ", $e->getMessage());
        }
    }


    /**
     * @Route("/post/delete/{id:[0-9]+}", name="adminpost-delete",methods={"GET"})
     */
    public function deleteAction()
    {
        $postId = $this->dispatcher->getParam('id', 'int');
        $post = Post::findFirstById($postId);

        if (!$post) {
            $this->flashSession->error("Invalid Post ID.");
            return $this->dispatcher->forward([
                'controller' => 'adminPost',
                'action'     => 'index'
            ]);
        }

        if (!$post->delete()) {
            $this->flashSession->error("Failed to delete post.");
        } else {
            $this->flashSession->success("Post deleted successfully.");
        }

        return $this->dispatcher->forward([
            'controller' => 'adminPost',
            'action'     => 'index'
        ]);
    }

    /**
     * @Route("/post/update/{id:[0-9]+}", name="adminpost-update", methods={"GET", "POST"})
     */
    public function updateAction()
    {
        $postId = $this->dispatcher->getParam('id', 'int');
        $post = Post::findFirstById($postId);

        if (!$post) {
            $this->flashSession->error("Invalid Post ID.");
            return $this->response->redirect('/admin');
        }

        $filters = [
            'user_id'     => $post->getUserId(),
            'title'     => $post->getTitle(),
            'content'     => $post->getContent(),
        ];

        $form = new CreateAndUpdatePostForm();
        $form->bind($filters);
        // var_dump($form->render("user_id"));

        $this->view->setVars([
            'postId' => $postId,
            'form' => $form
        ]);

        $this->view->pick('adminPost/update');

        if ($this->request->isPost()) {

            $post->assign([
                'user_id'    => $this->request->getPost('user_id') ?? "",
                'title'      => $this->request->getPost('title', 'string') ?? "",
                'content'    => $this->request->getPost('content', 'string') ?? "",
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
