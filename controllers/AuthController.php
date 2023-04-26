<?php

namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware( new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $LoginForm = new LoginForm();
        if ($request->isPost()) {
            $LoginForm->loadData($request->getBody());
            if($LoginForm->validate() && $LoginForm->login()) {
            $response->redirect('/');

            return;
            }
            return $this->render('login',['model'=> $LoginForm]);
        }


        $this->setLayout('auth');
        return $this->render('login',['model'=>$LoginForm] );
    }

    public function register(Request $request)
    {
        $user =new User();
        if ($request->isPost()){
          $user->loadData($request->getBody());
          if ($user->validate() && $user->register()){
              Application::$app->session->setFlash('success','Your registration has been completed successfully');
              Application::$app->response->redirect('/');

          }

            return $this->render('register',['model'=> $user]);
        }

      $this->setLayout('auth');
        return $this->render('register',['model'=> $user]);

    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');
    }

}