<?php

class DB
{
    private static $Conn;

    private static function getInstance()
    {
        if(!self::$Conn) {
            self::$Conn = new PDO('sqlite:db.sq3');
            self::$Conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$Conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$Conn;
    }

    public static function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";

        $rs = self::getInstance()->query($sql);

        $output = array();
        if($rs) {
            $output = $rs->fetchAll();
        }
        return $output;
    }
}
