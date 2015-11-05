<?php

namespace Wilson\Source;

use Wilson\Source\Connection;
use Exception;

abstract class Base
{
    public static $fields = [];

    public static function getConnection()
    {
        return Connection::connect();
    }

    public static function getTableName()
    {
        if(array_key_exists("table", self::$fields)){
            return self::$fields["table"];
        }
        else {
           throw new Exception("Table property unspecified in class instance.");
        }
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
        $offset = $position - 1;
        //SELECT * FROM table LIMIT $offset, 1
    }

    public static function getAll()
    {
        //SELECT * FROM table
        // $tableName = self::$fields["table"];
        // echo "Table: ".$tableName."<br />";
    }

    public static function save()
    {
        $tableName = self::getTableName();
        $tableColumns = implode(", ", array_keys(self::$fields));
        $columnValues = "'".implode("',' ", array_values(self::$fields))."'";

        try{
            $conn = self::getConnection();
            $sql = "INSERT INTO ".$tableName."($tableColumns) VALUES($columnValues)";
            $affectedRows = $conn->exec($sql);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function destroy($position)
    {
        $offset = $position - 1;
        //DELETE fFROM table WHERE field = $id
    }
}