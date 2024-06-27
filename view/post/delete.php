<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;

$pdo = DBManager::pdoConnexion();
$auth = new Auth($pdo);
if ($auth->requireRole('1')) {
  header('Location: /login');
  exit();
}

$id = (int) $params['id'];
$query = $pdo->prepare("DELETE FROM POSTS WHERE id = :id");
$query->execute(['id' => $id]);

$query = $pdo->prepare("DELETE FROM POSTS_CATEGORIES WHERE id_post = :id");
$query->execute(['id' => $id]);

header('Location: /editing');
exit();