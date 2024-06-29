<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
use App\dbManager\PostTable;

$pdo = DBManager::pdoConnexion();
$auth = new Auth($pdo);
if ($auth->requireRole('1')) {
  header('Location: /login');
  exit();
}

$id = (int) $params['id'];
$postTable = new PostTable($pdo);
$postTable->deletePost($id);

header('Location: /editing');
exit();