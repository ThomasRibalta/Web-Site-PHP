<?php
require dirname(__DIR__) . '/../vendor/autoload.php';

$title = 'Mon blog';

$pdo = new PDO('sqlite:'.dirname(__DIR__).'/../data/data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$nPage = (int)($_GET['page'] ?? 1) ?: 1;
$count = $pdo->query('SELECT COUNT(id) FROM POSTS')->fetch(PDO::FETCH_NUM)[0];
$perPage = 16;
$pages = ceil($count / $perPage);
if ($nPage > $pages) {
  header('Location: /');
  exit();
}
$offset = $perPage * ($nPage - 1);
$posts = $pdo->query("SELECT * FROM POSTS ORDER BY created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Post');

?>
<h1> Mon blog </h1>

<div class="row">
  <?php foreach($posts as $post): ?>
    <div class="col-md-3">
      <?php require 'card.php' ?>
    </div>
  <?php endforeach ?>
</div>

<?php for ($i = 1; $i <= $pages; $i++): ?>
  <a href="?page=<?= $i ?>" class="btn <?= ($nPage === $i) ? "btn-primary" : "btn-secondary"?>"><?= $i ?></a>
<?php endfor ?>
