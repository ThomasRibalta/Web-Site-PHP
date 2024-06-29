<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\dbManager\PostTable;

$pdo = DBManager::pdoConnexion();
$id = (int) $params['id'];
$slug = $params['slug'];

$postTable = new PostTable($pdo);
[$post, $post_categorie] = $postTable->findPostById($id, $slug);

?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?= $post->getTitle() ?></h5>
    <p class="card-text"><?= $post->getContent() ?></p>
    <p class="card-text"><small class="text-muted"><?= $post->getCreatedAt() ?></small></p>
  </div>
  <div class="mb-2">
    <?php foreach ($post_categorie as $categorie): ?>
      <a href="<?= $router->generateUrl('Category', ['slug' => $categorie->getSlug(), 'id' => $categorie->getId()]) ?>"><?=$categorie->getName()?></a>
    <?php endforeach ?>
  </div>
</div>

<div>
  <a href="/" class="btn btn-primary mt-4">Retour a l'accueil</a>
</div>