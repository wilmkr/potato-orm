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

    /**
     * This method return a database connection
     */
    public static function getConnection()
    {
        return Connection::connect();
    }

    /**
     * This method generate the database table name based on the entity name
     */
    public static function getTableName()
    {
        $table = substr(strrchr(get_called_class(), '\\'), 1);
        $table = strtolower($table).'s';

        return $table;
    }

    /**
     * Finds a record in the database table in the position denoted by the parameter passed
     * @param  integer $position
     */
    public static function find($position)
    {
        try {
            $offset = $position - 1;
            $tableName = self::getTableName();
            $conn = self::getConnection();

            $stmt = $conn->query('SELECT * FROM '.$tableName.' LIMIT '.$offset.', 1');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$result) {
                throw new Exception(" No record exists at position $position in the $tableName table.");
            }

            $object = new static;
            $object->id = $result['id'];
            $object->result = json_encode($result);

            return $object;
        }
        catch(PDOException $pe) {
            return $pe->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method fetches all the records in the database table and returns them in an array
     */
    public static function getAll()
    {
        try {
            $tableName = self::getTableName();
            $conn = self::getConnection();

            $stmt = $conn->query('SELECT * FROM '.$tableName);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe) {
            return $pe->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method inserts a new record into the database table or updates an already existing record
     */
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
        catch(PDOException $pe) {
            return $pe->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method generates the SQL statement used to update a record in the database
     */
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
            else if($key != "result") {
                $setClause = $setClause.$key." = '".$val."'";

                if($keysCount > 2 && $iterations < $keysCount) {
                    $setClause = $setClause.", ";
                }
            }
            $iterations++;
        }

        $sql = "UPDATE ".$tableName." SET ".$setClause.$whereClause;

        var_dump($sql);

        return $sql;
    }

    /**
     * This method deletes a record from the database table at the position denoted by the parameter passed in
     * @param  integer $position
     */
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
        catch(PDOException $pe) {
            return $pe->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
}