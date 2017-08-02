<?php

namespace BookStore\Models;

abstract class Model {

    protected $dbal;
    protected $table;

    function __construct($dbal) {
        $this->dbal = $dbal;
    }

    function getAll() {
        return $this->dbal
                        ->createQueryBuilder()
                        ->select("*")
                        ->from($this->table)
                        ->execute()
                        ->fetchAll();
    }

    function search($id, $fields = '*') {
        return $this->dbal
                        ->createQueryBuilder()
                        ->select($fields)
                        ->from($this->table)
                        ->where('id = ?')
                        ->setParameter(0, $id)
                        ->execute();
    }

    function exist($id) {
        return $this->search($id, 'id')->rowCount();
    }

    function findById($id, $fields = '*') {
        return $this->search($id, $fields)->fetchObject();
    }

    function update($data, $id) {
        return $this->dbal->update($this->table, $data, ['id' => $id]);
    }

    function insert($data) {
        return $this->dbal->insert($this->table, $data);
    }

    function delete($id) {
        return $this->dbal->delete($this->table, ['id' => $id]);
    }

}
