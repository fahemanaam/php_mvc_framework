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
       return $statement->execute();
    }

    public  function read($tableName): array
    {
        $statement = self::prepare("SELECT * FROM $tableName");
        $params =array();
        $statement->execute();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $params[$row['id']] = $row;
        }
      return $params;
    }

    public function selectById($table, int $id): array
    {
        $statement = self::prepare("SELECT * FROM $table WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

        $params = $statement->fetch(\PDO::FETCH_ASSOC);
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


    public  function delete(): bool
    {
        $tableName = $this->tableName();
        $primaryKey = $this->primaryKey();
        $statement= static::prepare("DELETE FROM $tableName WHERE $primaryKey=:$primaryKey");
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        return $statement->execute();
    }


    public function update(): bool
    {
        $tableName = $this->tableName();
        $primaryKey = $this->primaryKey();
        $attributes = $this->Attributes();
        $param = implode(",", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("UPDATE $tableName SET $param WHERE $primaryKey=:$primaryKey");
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});

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