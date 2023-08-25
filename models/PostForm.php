<?php

namespace app\models;

use app\core\DbModel;

 class PostForm extends DbModel
{
    public string $id = '';
    public string $subject = '';
    public string $topic = '';
    public string $photo= '';

    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'topic' => [self::RULE_REQUIRED],
        ];
    }

    public function tableName(): string
    {
        return 'posts';
    }

    public function attributes(): array
    {
        return ['subject','topic','photo'];
    }

    public function labels(): array
    {
        return [
            'subject' => 'Subject',
            'topic' => 'Topic',
        ];
    }

      public function index(): array
    {
        return $this->read('posts');
    }

       public function primaryKey(): string
     {
         return 'id';
     }


 }