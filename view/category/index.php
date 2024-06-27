<?php
$title = "Les categories";
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
$pdo = DBManager::pdoConnexion();
$query = $pdo->query("SELECT * FROM CATEGORIES");
$categories = $query->fetchAll(PDO::FETCH_CLASS, 'App\Model\Category');
?>

<h1>Les categories</h1>
<ul>
  <?php foreach($categories as $category): ?>
    <li>
      <a href="/category/<?= $category->getSlug() ?>-<?= $category->getId() ?>"><?= $category->getName() ?></a>
    </li>
  <?php endforeach ?>
</ul>