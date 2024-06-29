<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
use App\dbManager\PostTable;

$auth = new Auth(DBManager::pdoConnexion());
if ($auth->requireRole('1')) {
    header('Location: /login');
    exit();
}

$postTable = new PostTable(DBManager::pdoConnexion());
[$posts, $pagination] = $postTable->findPaginated();

?>
<div class="d-flex justify-content-between">
<h1> Editing POST</h1>
<a href="/editing/category" class="btn btn-primary h-100">Category</a>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Title</th>
      <th scope="col">Button</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($posts as $post):?>
      <tr>
      <th scope="col"><?=$post->getId()?></th>
      <th scope="col"><?=$post->getTitle()?></th>
      <th scope="col">
        <div>
          <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>" class="btn btn-primary">Show</a>
          <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>/edit" class="btn btn-warning">Edit</a>
          <a href="/posts/<?=$post->getSlug()?>-<?=$post->getId()?>/delete" class="btn btn-danger">Delete</a>
        </div>
      </th>
      </tr>
    <?php endforeach?>
  </tbody>
</table>
<a href="/newPost" class="btn btn-primary">Create a new Post</a>

<?= $pagination->getPageNumberList() ?>
