<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\dbManager\PostTable;

$title = 'Mon blog';

$postTable = new PostTable(DBManager::pdoConnexion());
$posts = $postTable->findPaginated();

?>
<h1> Mon blog </h1>

<div class="row">
  <?php foreach($posts[0] as $post): ?>
    <div class="col-md-3">
      <?php require 'card.php' ?>
    </div>
  <?php endforeach ?>
</div>

<?= $posts[1]->getPageNumberList() ?>
