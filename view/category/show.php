<?php
$title = 'Ma categorie';
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Helper\Url;

$pdo = \App\dbManager\DBManager::pdoConnexion();
$nPage = Url::getIntValue('page');
$id = (int) $params['id'];
$count = $pdo->query("SELECT COUNT(id_post) FROM POSTS_CATEGORIES WHERE id_categorie=$id")->fetch(PDO::FETCH_NUM)[0];
$perPage = 16;
$pages = ceil($count / $perPage);
if ($nPage > $pages) {
  header('Location: /');
  exit();
}
$offset = $perPage * ($nPage - 1);
$slug = $params['slug'];
$posts = $pdo->query("SELECT p.* FROM POSTS p JOIN POSTS_CATEGORIES pc ON pc.id_post = p.id WHERE id_categorie=$id LIMIT $perPage OFFSET $offset")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Post');
?>

<h1><?= $slug ?></h1>

<div class="row">
  <?php foreach($posts as $post): ?>
    <div class="col-md-3">
      <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
  <?php endforeach ?>
</div>

<?php for ($i = 1; $i <= $pages; $i++): ?>
  <a href="?page=<?= $i ?>" class="btn <?= ($nPage === $i) ? "btn-primary" : "btn-secondary"?>"><?= $i ?></a>
<?php endfor ?>