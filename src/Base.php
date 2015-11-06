<?php

namespace Wilson\Source;

use PDO;
use Exception;
use Wilson\Source\Connection;

abstract class Base
{
    public static $fields = [];
    public static $id;

    public static function getConnection()
    {
        return Connection::connect();
    }

    public static function getTableName()
    {
        // if(array_key_exists("table", self::$fields)){
        //     return self::$fields["table"];
        // }
        // else {
        //    throw new Exception("Table property unspecified in class instance.");
        // }
        return "users";
    }

    public function __set($property, $value)
    {
        self::$fields[$property] = $value;
    }

    public function __get($property)
    {
        return self::$fields[$property];
    }

    public static function find($position)
    {
        try {
            $offset = $position - 1;
            $object = new static;
            $tableName = self::getTableName();
            $conn = self::getConnection();

            $stmt = $conn->query('SELECT * FROM '.$tableName.' LIMIT '.$offset.', 1');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $object->id = $result['id'];
            return $object;

            // echo '>>>>>>>>><br />';
            // echo 'id before '.self::$id.'<br />';
            // $record = $stmt->fetchObject();
            // self::$id = $record->id;
            // echo 'id after '.s elf::$id.'<br />';
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        catch(Exception $e2) {
            return $e2->getMessage();
        }
    }

    public static function test(){
        echo 'test() ';
        var_dump(self::$fields);
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
        $tableColumns = implode(", ", array_keys(self::$fields));
        $columnValues = "'".implode("',' ", array_values(self::$fields))."'";

        try{
            $tableName = self::getTableName();
            $conn = self::getConnection();

            if(array_key_exists("id", self::$fields)){
                //update existing record
                //UPDATE table SET
            }
            else {
                //insert a new record
                $sql = "INSERT INTO ".$tableName."($tableColumns) VALUES($columnValues)";
                $affectedRows = $conn->exec($sql);
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        catch(Exception $e2) {
            echo $e2->getMessage();
        }
    }

    public static function destroy($position)
    {
        $offset = $position - 1;
        //DELETE fFROM table WHERE field = $id
    }
}