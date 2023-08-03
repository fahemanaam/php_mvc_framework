<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\PostForm;

class PostController extends Controller {

    public function show()
    {
        $postModel = new PostForm();
        $posts = $postModel->index();
        $this->params['posts'] = $posts;
        return $this->render('posts', $this->params);
    }

    public function edit(Request $request)
    {

        $postModel = new PostForm();
        $id = $request->getRouteParam('id');
        $edit = $postModel->editPost($id);
        $this->params['edit']=$edit;

     return $this->render('edit',$this->params);
    }
    public function delete(Request $request)
    {
        $id = $request->getRouteParam('id');

        $postModel = new PostForm();
        $postModel->destroy($id);
        $posts = $postModel->index();
        $this->params['posts'] = $posts;
        return $this->render('posts', $this->params);
    }


//    public function update(Request $request)
//    {
//        $postModel = new PostForm();
//        if ($request->isPost())
//        {
//            $id = $_POST['id'];
//            $postModel->updatePost($id);
//            $this->params['posts'] = $postModel;
//               }
//      return $this->render('update', $this->params);
//    }

    public function update(Request $request)
    {
        $postModel = new PostForm();
        if ($request->isPost())
        {
            $id = $_POST['id'];
            // Получение остальных данных из формы
            $subject = $_POST['subject'];
            $topic = $_POST['topic'];
            // Передача этих данных в метод updatePost()
            $postModel->updatePost($id, $subject, $topic);
            $this->params['posts'] = $postModel;
        }
        return $this->render('update', $this->params);
    }

}

