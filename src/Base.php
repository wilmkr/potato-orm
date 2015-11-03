<?php

namespace Wilson\Source

use Wilson\Source\Connection;

public class Base
{
    public static function find($position)
    {
        $offset = $position - 1;
        //SELECT * FROM table LIMIT $offset, 1
    }

    public static function getAll()
    {
        //SELECT * FROM table
    }

    public static function save()
    {
        // $stmt = $db->prepare("INSERT INTO table(field1,field2,field3,field4,field5) VALUES(:field1,:field2,:field3,:field4,:field5)");
        // $stmt->execute(array(':field1' => $field1, ':field2' => $field2, ':field3' => $field3, ':field4' => $field4, ':field5' => $field5));
        // $affected_rows = $stmt->rowCount();
    }

    public static function destroy($position)
    {
        $offset = $position - 1;
        //DELETE fFROM table WHERE field = $id
    }
}