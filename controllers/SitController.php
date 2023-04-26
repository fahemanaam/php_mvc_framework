<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;
use app\models\PostForm;


class SitController extends Controller
{

    public function home()
    {
        $params = [
            'name'=>  'Fahem'
        ];
        return $this->render('home', $params);
    }
    public function contact(Request $request, Response $response)
    {
        $contactForm = new ContactForm();

        if ($request->isPost()) {
            $contactForm->loadData($request->getBody());
            if($contactForm->validate() && $contactForm->send()) {
                $response->redirect('/');
                //return 'show data';
            }
            return $this->render('contact',['model'=> $contactForm]);
        }
       return $this->render('contact',['model'=>$contactForm]);
    }

    public function post(Request $request )
    {
        $PostForm =new PostForm();
        if ($request->isPost()){
            $PostForm->loadData($request->getBody());
        if($PostForm->validate() && $PostForm->save()){
            Application::$app->session->setFlash('success','Your post added successfully');
            Application::$app->response->redirect('post');

        }
            return $this->render('post' , ['model'=>$PostForm]);


        }
        return $this->render('post' , ['model'=>$PostForm]);
    }
    public function about()
    {
        return $this->render('about' );
    }

}