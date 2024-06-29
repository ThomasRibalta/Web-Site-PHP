<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\{DBManager, PostTable};
use App\Auth;

$pdo = DBManager::pdoConnexion();
$auth = new Auth($pdo);
$postTable = new PostTable($pdo);

$id = (int) $params['id'];
if ($auth->requireRole('1')) {
  header('Location: /login');
  exit();
}
if (!empty($_POST)) {
  $title = $_POST['Title'];
  $slug = $_POST['slug'];
  $content = $_POST['content'];
  $postTable->updatePost($id, $title, $slug, $content);
  header('Location: /editing');
  exit();
}
$slug = $params['slug'];
[$post, $post_categorie] = $postTable->findPostById($id, $slug);

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