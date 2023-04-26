<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\PostForm;

class PostController  {

    public function delete(Request $request,$id) {
        $post= new PostForm();
        if ($request->isPost())
        {
           $post->delete($id);
           Application::$app->session->setFlash('success', 'post successfully deleted');
           Application::$app->response->redirect('/');
        }
    }
}
