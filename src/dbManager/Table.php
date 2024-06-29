<?php
namespace App\dbManager;

class Table {
  protected $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }
}