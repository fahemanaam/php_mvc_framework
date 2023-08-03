<?php

namespace app\core;

use PDO;

abstract class DbModel extends Model
{
    abstract public function tableName():string;
    abstract public function attributes():array;
    abstract public function primaryKey():string;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes= $this->attributes();
        $params= array_map(fn($attr)=> ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).")
                VALUES (".implode(',', $params).")
        " );
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public  function select($tableName): array
    {
        $statement = self::prepare("SELECT * FROM $tableName");
        $params =array();
        $statement->execute();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $params[$row['id']] = $row;
        }
      return $params;
    }

    public function selectById($table,int $id): array
    {
        $statement = self::prepare("SELECT * FROM $table WHERE id = :id");
        $params = [];
        $statement->bindValue(":id", $id);
        $statement->execute();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $params[$row['id']] = $row;
        }
        return $params;

    }

    public function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function read()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
       return  $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public  function delete($id)
    {
        $tableName = $this->tableName();
        $statement= static::prepare("DELETE FROM $tableName WHERE id= :id");
        $statement->bindValue(':id',$id);

        $statement->execute();
    }



    public function update($tableName,  int $id): bool
    {
//        $attributes =$this->attributes();
//        $param = implode(",", array_map(fn($attr) => "$attr = :$attr", $attributes));
//        $statement = self::prepare("UPDATE $tableName SET $param WHERE id= :id");
//        $statement->bindValue('id', $id);
//       $statement->execute();
//         return  true;


        $attributes = $this->attributes();
        $param = implode(",", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("UPDATE $tableName SET $param WHERE id=:id");
        $statement->bindValue(':id', $id);
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        return $statement->execute();
    }


    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }


}