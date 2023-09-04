<?php

namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;



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


    public function about()
    {
        return $this->render('about' );
    }

}