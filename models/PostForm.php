<?php

namespace app\models;
use app\core\DbModel;
class PostForm extends DbModel
{
    public int $id;
    public string  $subject ='';
    public string $topic= '';
    public array $data = [];

    public function rules(): array
    {
        return [
            'subject'=>[self::RULE_REQUIRED],
            'topic'=>[self::RULE_REQUIRED],
        ];
    }

    public function tableName():string
    {
        return 'posts' ;
    }

    public function attributes():array
    {
        return['subject','topic'];
    }

    public function labels():array
    {
        return [
            'subject'=> 'Subject',
            'topic'=> 'Topic4',

        ];
    }
    public function add(): bool
    {
            return $this->save();

    }


    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }


}