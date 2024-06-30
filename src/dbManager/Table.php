<?php
namespace App\dbManager;

/**
 * Table - Parent class for all tables
 */
class Table {
  protected $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }
}