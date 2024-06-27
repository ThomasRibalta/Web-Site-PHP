<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\Helper\Url;
use App\Auth;

$pdo = DBManager::pdoConnexion();
$auth = new Auth($pdo);
$id = (int) $params['id'];
if ($auth->requireRole('1')) {
  header('Location: /login');
  exit();
}

if (!empty($_POST)) {
  $title = $_POST['Title'];
  $slug = $_POST['slug'];
  $content = $_POST['content'];
  // Préparer la requête avec des paramètres liés
  $stmt = $pdo->prepare("UPDATE POSTS SET title = :title, slug = :slug, content = :content WHERE id = :id");
  $stmt->execute(['title' => $title,
                  'slug' => $slug,
                  'content' => $content,
                  'id' => $id]);
  header('Location: /editing');
  exit();
}

$slug = $params['slug'];
$post = $pdo->query("SELECT * FROM POSTS WHERE id=$id")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Post')[0];
Url::is_good_post($post, $slug, $id);
$post_categorie = $pdo->query("SELECT c.* FROM CATEGORIES c JOIN POSTS_CATEGORIES pc ON c.id = pc.id_categorie WHERE pc.id_post = $id")->fetchAll(PDO::FETCH_CLASS, 'App\Model\Category');

?>
<form method="post">
  <div class="mb-3">
    <label for="Title" class="form-label">Title</label>
    <input type="text" class="form-control" name="Title" placeholder="" value="<?=$post->getTitle()?>">
  </div>
  <div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" class="form-control" name="slug" placeholder="" value="<?=$post->getSlug()?>">
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">Content</label>
    <textarea class="form-control" name="content" rows="15"><?=$post->getContent()?></textarea>
  </div>
  <button type="submit" class="btn btn-warning mt-4">Update</button>
</form>