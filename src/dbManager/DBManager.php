<?php

namespace App\dbManager;

use PDO;

class dbManager{
  public static function pdoConnexion(): PDO{
    return new PDO('sqlite:'.dirname(__DIR__).'/../data/data.db', null, null, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }
}