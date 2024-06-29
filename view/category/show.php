<?php
$title = 'Ma categorie';
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\dbManager\PostTable;

$id = (int) $params['id'];
$slug = $params['slug'];

$postTable = new PostTable(DBManager::pdoConnexion());
[$posts, $pagination, $category] = $postTable->getPostByCategory($id, $slug);

?>

<h1><?= $category->getName() ?></h1>

<div class="row">
  <?php foreach($posts as $post): ?>
    <div class="col-md-3">
      <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
  <?php endforeach ?>
</div>

<?= $pagination->getPageNumberList() ?>
