<?php

namespace TestRest\Entity;

class Entity {

  /**
   * @var String
   */
  protected $table;

  /**
   * @var String
   */
  protected $idTable = 'id';

  /**
   * @var Pdo
   */
  protected $conn;

  /**
   * Set $pdo
   */
  public function __construct(\PDO $conn) {
    $this->conn = $conn;
  }

  /**
   * Set Table
   */
  public function setTable($table) {
    $this->table = $table;
  }

  /**
   * Set Id Table
   */
  public function setIdTable($idTable) {
    $this->idTable = $idTable;
  }

  /**
   * Save data in database (Insert Or Update)
   * @return bool
   */
  public function save(array $data) {
    if (array_key_exists($this->idTable, $data)) {
      return $this->update($data[$this->idTable], $data);
    } else {
      return $this->insert($data);
    }
  }

  /**
   * Insert data in database
   * @return bool
   */
  private function insert(array $data = array()) {
    foreach ($data as $key => $value) {
      $fields[] = $key;
      $bind[] = ':' . $key;
    }

    $fields = implode(', ', $fields);
    $bind = implode(', ', $bind);

    $sql = "INSERT INTO " . $this->table . "(" . $fields . ") 
	              	    VALUES(" . $bind . ")";

    $insert = $this->conn->prepare($sql);

    foreach ($data as $key => $value) {
      $insert->bindValue(":" . $key, $value, !is_int($value) ? \PDO::PARAM_STR : \PDO::PARAM_INT);
    }
    $insert->execute();

    return $this->getById($this->conn->lastInsertId());
  }

  /**
   * Update data in database
   * @return bool
   */
  private function update($id, array $datas) {
    $datasSql = '';

    foreach ($datas as $key => $a) {
      $datasSql .= $key . ' = ' . ':' . $key . ', ';
    }

    $datasSql = substr($datasSql, 0, -2);

    $sql = "UPDATE " . $this->table . " SET " . $datasSql . " WHERE " . $this->idTable . " = :id";

    try {
      $update = $this->conn->prepare($sql);

      $update->bindValue(':id', $id, \PDO::PARAM_INT);

      foreach ($datas as $key => $value) {
        $update->bindValue(":" . $key, $value, !is_int($value) ? \PDO::PARAM_STR : \PDO::PARAM_INT);
      }

      $update->execute();

      return $this->getById($id);
    } catch (PDOexception $e) {
      return false;
    }
  }

  /**
   * Get all datas in bd
   * @return array with datas
   */
  public function getAll($fields = '*') {
    $sql = "SELECT " . $fields . " FROM " . $this->table;

    $select = $this->conn->prepare($sql);
    $select->execute();

    return $select->fetchAll(\PDO::FETCH_ASSOC);
  }

  /**
   * Get especific data
   * 
   */
  public function where($where, $fields = '*', $more = 'AND') {
    $whereSql = '';
    foreach ($where as $key => $w) {
      $whereSql .= (empty($whereSql) ? '' : ' ' . $more . ' ' ) . $key . ' = :' . $key;
    }

    $sql = "SELECT " . $fields . " FROM " . $this->table . " WHERE " . $whereSql;

    $select = $this->conn->prepare($sql);
    foreach ($where as $key => $value) {
      $select->bindValue(":" . $key, $value, is_int($value) ? \PDO::PARAM_STR : \PDO::PARAM_INT);
    }
    $select->execute();

    return $select->fetchAll(\PDO::FETCH_ASSOC);
  }

  /**
   * Get especific data by id
   * 
   */
  public function getById($id) {

    $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->idTable . ' = :id';

    $select = $this->conn->prepare($sql);
    $select->bindValue(":id", $id, is_int($id) ? \PDO::PARAM_STR : \PDO::PARAM_INT);
    $select->execute();

    return $select->fetch(\PDO::FETCH_ASSOC);
  }

  /**
   * Delete data
   * @param   [id] [data's id]
   */
  public function delete($id) {
    $sql = "DELETE FROM " . $this->table . " WHERE " . $this->idTable . " = :id";

    $delete = $this->conn->prepare($sql);
    $delete->bindValue(':id', $id, \PDO::PARAM_INT);

    if ($delete->execute()) {
      return [$this->idTable => $id];
    }
  }

  /**
   * Count total itens in especific table
   * @return int total of registries
   */
  public function getCount() {
    return count($this->getAll());
  }

}
