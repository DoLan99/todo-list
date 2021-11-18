<?php

namespace App\Core;

use App\Core\Application;

abstract class Model
{
    abstract public static function tableName();

    public function primaryKey()
    {
        return 'id';
    }

    public static function prepare($sql)
    {
        return Application::$app->db->prepare($sql);
    }

    public function attributes()
    {
        return [];
    }

    public function save(array $data)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $data[$attribute]);
        }
        $statement->execute();
        return true;
    }

    public function update(array $data, int $id)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($data);
        $params = array_map(fn($attr) => "$attr=:$attr", $attributes);
        $statement = self::prepare("UPDATE $tableName SET ". implode(",", $params) ." WHERE id=:id");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $data[$attribute]);
        }
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }

    public static function getAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE deleted_at IS NULL");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findOne(array $where, array $select = ['*'])
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $select = implode(',', $select);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT $select FROM $tableName WHERE $sql AND deleted_at IS NULL");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}