<?php

namespace Wilson\Source;

use PDO;
use Exception;
use Wilson\Source\Connection;

abstract class Base
{
    public static $fields = [];

    public function __set($property, $value)
    {
        self::$fields[$property] = $value;
    }

    public function __get($property)
    {
        return self::$fields[$property];
    }

    public static function getConnection()
    {
        return Connection::connect();
    }

    public static function getTableName()
    {
        return strtolower(substr(strrchr(get_called_class(), '\\'), 1)).'s';
        //return "users";
    }

    public static function find($position)
    {
        try {
            $offset = $position - 1;
            $tableName = self::getTableName();
            $conn = self::getConnection();

            $stmt = $conn->query('SELECT * FROM '.$tableName.' LIMIT '.$offset.', 1');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $object = new static;
            $object->id = $result['id'];

            return $object;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        catch(Exception $e2) {
            return $e2->getMessage();
        }
    }

    public static function getAll()
    {
        try {
            $tableName = self::getTableName();
            $conn = self::getConnection();

            $stmt = $conn->query('SELECT * FROM '.$tableName);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        catch(Exception $e2) {
            return $e2->getMessage();
        }
    }

    public static function save()
    {
        try {
            $tableName = self::getTableName();
            $affectedRows = 0;
            $conn = self::getConnection();

            if(array_key_exists("id", self::$fields)){
                //update an existing record
                $sql = self::makeUpdateSQL();
            }
            else {
                //insert a new record
                $tableColumns = implode(", ", array_keys(self::$fields));
                $columnValues = "'".implode("',' ", array_values(self::$fields))."'";
                $sql = "INSERT INTO ".$tableName."($tableColumns) VALUES($columnValues)";
            }

            $affectedRows = $conn->exec($sql);

            return $affectedRows;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        catch(Exception $e2) {
            return $e2->getMessage();
        }
    }

    public static function makeUpdateSQL()
    {
        $tableName = self::getTableName();
        $setClause = "";
        $whereClause = "";
        $keysCount = count(self::$fields);
        $iterations = 1;
        foreach(self::$fields as $key => $val)
        {
            if($key == "id") {
                $whereClause = " WHERE id = ".$val;
            }
            else {
                $setClause = $setClause.$key." = '".$val."'";
                if($keysCount > 2 && $iterations < $keysCount) {
                    $setClause = $setClause.", ";
                }
            }
            $iterations++;
        }
        $sql = "UPDATE ".$tableName." SET ".$setClause.$whereClause;

        return $sql;
    }

    public static function destroy($position)
    {
        $record = self::find($position);
        $id = $record->id;

        try {
            $tableName = self::getTableName();
            $conn = self::getConnection();
            $sql = "DELETE FROM ".$tableName ." WHERE id = ".$id;
            $affectedRows = $conn->exec($sql);

            return $affectedRows;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        catch(Exception $e2) {
            return $e2->getMessage();
        }
    }
}