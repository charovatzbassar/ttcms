<?php

require_once dirname(__FILE__)."/../../config.php";

class BaseDao {
    protected $connection;

    private $table;
  
    public function beginTransaction() {
       $this->connection->beginTransaction();
    }
  
    public function commit() {
      $this->connection->commit();
    }
  
    public function rollback() {
       $this->connection->rollBack();
    }
    public function parseOrder($order)
    {
      switch (substr($order, 0, 1)) {
        case '-':
          $order_direction = "ASC";
          break;
        case '+':
          $order_direction = "DESC";
          break;
        default:
          throw new Exception("Invalid order format. First character should be either + or -");
          break;
      };
  
      // Filter SQL injection attacks on column name
      $order_column = trim($this->connection->quote(substr($order, 1)), "'");
  
      return [$order_column, $order_direction];
    }
  
    public function __construct($table)
    {
      $this->table = $table;
      try {
        $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8;port=" . DB_PORT, DB_USER, DB_PASS, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
      } catch (PDOException $e) {
        print_r($e);
        throw $e;
      }
    }
  
    public function insert($table, $entity)
    {
      $query = "INSERT INTO {$table} (";
      foreach ($entity as $column => $value) {
        $query .= $column . ", ";
      }
      $query = substr($query, 0, -2);
      $query .= ") VALUES (";
      foreach ($entity as $column => $value) {
        $query .= ":" . $column . ", ";
      }
      $query = substr($query, 0, -2);
      $query .= ")";
  
      $stmt = $this->connection->prepare($query);
      $stmt->execute($entity); // SQL injection prevention
      $entity['id'] = $this->connection->lastInsertId();
      return $entity;
    }
  
    protected function executeUpdate($table, $id, $entity, $id_column = "id")
    {
      $query = "UPDATE {$table} SET ";
      foreach ($entity as $name => $value) {
        $query .= $name . "= :" . $name . ", ";
      }
      $query = substr($query, 0, -2);
      $query .= " WHERE {$id_column} = :$id_column";
  
      $stmt = $this->connection->prepare($query);
      $entity[$id_column] = $id;
      $stmt->execute($entity);
    }
  
    protected function query($query, $params)
    {
      $stmt = $this->connection->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    protected function queryUnique($query, $params)
    {
      $results = $this->query($query, $params);
      return reset($results);
    }
  
    protected function execute($query, $params)
    {
      $prepared_statement = $this->connection->prepare($query);
      if ($params) {
        foreach ($params as $key => $param) {
          $prepared_statement->bindValue($key, $param);
        }
      }
      $prepared_statement->execute();
      return $prepared_statement;
    }
  
    public function add($entity)
    {
      return $this->insert($this->table, $entity);
    }
  
    public function update($id, $entity, $id_column = "id")
    {
      $this->executeUpdate($this->table, $id, $entity, $id_column); 
    }

    public function delete($id, $id_column = "id") {
      return $this->query("DELETE FROM " . $this->table . " WHERE $id_column = :$id_column", [$id_column => $id]);
    }
  
    public function get_by_id($id, $id_column = "id")
    {
      return $this->queryUnique("SELECT * FROM " . $this->table . " WHERE $id_column = :$id_column", [$id_column => $id]);
    }
  
    public function get($offset = 0, $limit = 25, $order = "-id")
    {
      list($order_column, $order_direction) = self::parseOrder($order);
  
      return $this->query("SELECT *
                           FROM " . $this->table . "
                           ORDER BY {$order_column} {$order_direction}
                           LIMIT {$limit} OFFSET {$offset}", []);
    }

    public function get_all()
    {
      return $this->query("SELECT * FROM " . $this->table, []);
    }
}

?>