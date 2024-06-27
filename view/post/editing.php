<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
use App\Helper\Url;
use App\Pagination;

$auth = new Auth(DBManager::pdoConnexion());
if ($auth->requireRole('1')) {
    header('Location: /login');
    exit();
}

$pagination = new Pagination("SELECT * FROM POSTS ORDER BY created_at", "SELECT COUNT(id) FROM POSTS", 'App\Model\Post', "/");
$posts = $pagination->getItems();

?>
<h1> Editing </h1>

<?php foreach($posts as $post): ?>
  <div class="card mt-1">
  <div class="card-body d-flex justify-content-between">
    <h5 class="card-title"><?=$post->getTitle()?></h5>
    <div>
      <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>" class="btn btn-primary">Show</a>
      <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>/edit" class="btn btn-warning">Edit</a>
      <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>/delete" class="btn btn-danger">Delete</a>
    </div>
  </div>
</div>
<?php endforeach ?>

<?= $pagination->getPageNumberList() ?>
