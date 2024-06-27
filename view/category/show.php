<?php
$title = 'Ma categorie';
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Helper\Url;
use App\dbManager\DBManager;
use App\Pagination;

$id = (int) $params['id'];
$slug = $params['slug'];
$pagination = new Pagination("SELECT p.* FROM POSTS p JOIN POSTS_CATEGORIES pc ON pc.id_post = p.id WHERE id_categorie=$id", "SELECT COUNT(id_post) FROM POSTS_CATEGORIES WHERE id_categorie=$id", 'App\Model\Post', "/category/$slug-$id");
$posts = $pagination->getItems();
$category = DBManager::pdoConnexion()->query("SELECT * FROM CATEGORIES WHERE id=$id")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Category')[0];
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
