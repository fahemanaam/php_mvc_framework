<?php
namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\PostForm;

class PostController extends Controller {

    public function addPost(Request $request )
    {
        $PostForm =new PostForm();
        if ($request->isPost()){
            $PostForm->loadData($request->getBody());

            if($PostForm->validate() && $PostForm->save()){
                Application::$app->session->setFlash('success','Your post added successfully');
                Application::$app->response->redirect('post');
                $PostForm->loadData([]);
            }
            return $this->render('post' , ['model'=>$PostForm]);
        }
        return $this->render('post' , ['model'=>$PostForm]);
    }

    public function show()
    {
        $postModel = new PostForm();
        $posts = $postModel->index();
        $this->params['posts'] = $posts;
        return $this->render('posts', $this->params);
    }

    public function edit(Request $request)
    {
        $id = $request->getRouteParam('id');
        $postModel = new PostForm();
        if ($request->isGet()) {
            $editData = $postModel->selectById('posts', $id);
            $postModel->loadData($editData);
        }
        $this->params['model'] = $postModel;
        return $this->render('edit', $this->params);
    }

    public function delete(Request $request)
    {
        $id = $request->getRouteParam('id');
        $postModel = new PostForm();
        $postModel->{$postModel->primaryKey()} = $id;
        if ($request->isDelete()) {
            $postModel->delete();
        }
        $posts = $postModel->index();
        $this->params['posts'] = $posts;
        return $this->render('posts', $this->params);
    }



    public function update(Request $request)
    {
        $postModel = new PostForm();
        if ($request->isPost())
        {
            $postModel->loadData($request->getBody());
            if($postModel->validate() && $postModel->update()) {
                Application::$app->session->setFlash('success', 'Your post was updated successfully');
                Application::$app->response->redirect('posts');
                $postModel->loadData([]);
            }
            return $this->render('edit', ['model' => $postModel]);
        }
        return $this->render('posts', ['model' => $postModel]);
    }


}

