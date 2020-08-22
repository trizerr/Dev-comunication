<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $password = DB_PASS;
  private $dbName = DB_NAME;

  private $pdo;
  private $stmt;
  private $error;


  public function __construct()
  {
    $dsn = "mysql:host=$this->host;dbname=$this->dbName";
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    // Create PDO instance
    try {
      $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
      die();
    }

  }

  public function query($sql)
  {
    $this->stmt = $this->pdo->prepare($sql);
  }

  public function bind($param, $value, $type = null)
  {
    if ($type === null) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case $value === null:
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute()
  {
    return $this->stmt->execute();
  }



  public function row($sql)
  {
    $result = $this->pdo->query($sql);
    return $result->fetchAll();
  }

//  public function column($sql)
//  {
//    $result = $this->pdo->query($sql);
//    return $result->fetchColumn();
//  }


}