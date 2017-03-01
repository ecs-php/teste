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

    public static function getAllFrom($table, array $fields)
    {
        $fields = implode(', ', $fields);

        $sql = "SELECT {$fields} FROM {$table}";

        $rs = self::getInstance()->query($sql);

        $output = array();
        if($rs) {
            $output = $rs->fetchAll();
        }

        return $output;
    }

    public static function getOneByIdFrom($table, array $fields, $id)
    {
        $fields = implode(', ', $fields);

        $sql = "SELECT {$fields} FROM {$table} WHERE id = {$id}";

        $rs = self::getInstance()->query($sql);
        $item = $rs->fetch();

        if(!$item)
            return array();

        return $item;
    }

    public static function getOneByField($table, array $fields)
    {
        $clauses = array();
        $values = array();
        foreach($fields as $field => $value) {
            $clauses[] = "{$field} = ?";
            $values[] = $value;
        }
        $clauses = implode(' AND ', $clauses);

        $sql = "SELECT * FROM {$table} WHERE {$clauses}";
        $st = self::getInstance()->prepare($sql);
        $st->execute($values);

        if(!$st)
            return false;

        return $st->fetch();
    }

    public static function saveAt($table, array $data)
    {
        if(!$data['id'])
            return self::insert($table, $data);

        return self::update($table, $data);
    }

    public function removeFrom($table, array $data)
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";

        $st = self::getInstance()->prepare($sql);
        $st->execute(array($data['id']));

        return $data;
    }

    private function insert($table, array $data)
    {
        $fields = array();
        $values = array();

        foreach($data as $field => $value) {
            if(in_array($field, array('id')))
                continue;

            $fields[] = $field;
            $values[] = $value;

            $placeholders[] = '?';
        }

        $fields = implode(', ', $fields);
        $placeholders = implode(', ', $placeholders);

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $st = self::getInstance()->prepare($sql);
        $st->execute($values);

        $data['id'] = self::getInstance()->lastInsertId();

        return $data;
    }

    private function update($table, array $data)
    {
        $clauses = array();
        $values = array();

        foreach($data as $field => $value) {
            if(in_array($field, array('id')))
                continue;

            $clauses[] = "{$field} = ?";
            $values[] = $value;
        }

        $clauses = implode(', ', $clauses);

        $sql = "UPDATE {$table} SET {$clauses} WHERE id = {$data['id']}";
        $st = self::getInstance()->prepare($sql);
        $st->execute($values);

        return $data;
    }

    public function saveAuthTokenFor($table, $id, $auth_token)
    {
        $sql = "UPDATE {$table} SET auth_token = ? WHERE id = ?";
        $st = self::getInstance()->prepare($sql);
        $st->execute(array($auth_token, $id));
    }
}
