<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\Helper\Url;
use App\Pagination;

$title = 'Mon blog';

$pagination = new Pagination("SELECT * FROM POSTS ORDER BY created_at", "SELECT COUNT(id) FROM POSTS", 'App\Model\Post', "/");
$posts = $pagination->getItems();

?>
<h1> Mon blog </h1>

<div class="row">
  <?php foreach($posts as $post): ?>
    <div class="col-md-3">
      <?php require 'card.php' ?>
    </div>
  <?php endforeach ?>
</div>

<?= $pagination->getPageNumberList() ?>
