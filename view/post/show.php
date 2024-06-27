<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\Helper\Url;

$pdo = DBManager::pdoConnexion();
$id = (int) $params['id'];
$slug = $params['slug'];
$post = $pdo->query("SELECT * FROM POSTS WHERE id=$id")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Post')[0];
Url::is_good_post($post, $slug, $id);
$post_categorie = $pdo->query("SELECT c.* FROM CATEGORIES c JOIN POSTS_CATEGORIES pc ON c.id = pc.id_categorie WHERE pc.id_post = $id")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Category');

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