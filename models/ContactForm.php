<?php

namespace app\models;


use app\core\Application;
use app\core\Model;

class ContactForm extends Model
{

    public string  $topic ='';
    public string $email= '';
    public string  $subject ='';

    public function rules(): array
    {
        return [
            'subject'=>[self::RULE_REQUIRED],
            'email'=>[self::RULE_REQUIRED, self::RULE_EMAIL],
            'topic'=>[self::RULE_REQUIRED],
        ];
    }

//    public function tableName():string
//    {
//        return 'posts' ;
//    }

    public function attributes():array
    {
        return['subject', 'email','topic'];
    }

    public function labels():array
    {
        return [
            'subject'=> 'Subject',
            'email'=> 'Email',
            'topic'=> 'Topic',

        ];
    }
    public function send()
    {
        Application::$app->session->setFlash('success', 'thanks for contact us');
        Application::$app->response->redirect('/contact');
    }

 }