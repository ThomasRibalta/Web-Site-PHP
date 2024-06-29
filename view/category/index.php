<?php
$title = "Les categories";
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\dbManager\CategoryTable;

$pdo = DBManager::pdoConnexion();
$categoryTable = new CategoryTable($pdo);
[$categories, $pagination] = $categoryTable->findPaginated();
?>

<h1>Les categories</h1>
<ul>
  <?php foreach($categories as $category): ?>
    <li>
      <a href="/category/<?= $category->getSlug() ?>-<?= $category->getId() ?>"><?= $category->getName() ?></a>
    </li>
  <?php endforeach ?>
</ul>

<?= $pagination->getPageNumberList() ?>