<?php

namespace app\models;
use app\core\DbModel;
class PostForm extends DbModel
{
    public string  $subject ='';
    public string $topic= '';


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
//    public function add(): bool
//    {
////        /return $this->save();
//
//    }


    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }

    public function index(): array
    {
        return $this->select('posts');
    }

    public function destroy($id)
    {
      $this->delete($id);
    }

    public function editPost($id): array
    {
        return $this->selectById('posts', $id);
    }

//    public function updatePost($id): bool
//    {
//      return $this->update('posts', $id);
//
//    }
    public function updatePost($id, $subject, $topic): bool
    {
        // Установка атрибутов модели перед обновлением
        $this->subject = $subject;
        $this->topic = $topic;
        return $this->update('posts', $id);
    }


}