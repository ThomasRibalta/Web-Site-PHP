<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
use App\dbManager\PostTable;
use App\dbManager\CategoryTable;

$auth = new Auth(DBManager::pdoConnexion());
if ($auth->requireRole('1')) {
    header('Location: /login');
    exit();
}

$postTable = new PostTable(DBManager::pdoConnexion());
$categoryTable = new CategoryTable(DBManager::pdoConnexion());
$categories = $categoryTable->findAllCategories();

if (!empty($_POST)) {
    $postTable->createPost($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['category']);
    header('Location: /editing/post');
    exit();
}

?>

<h1>New Post</h1>

<form method='post' action="/newPost">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" id="category" name="category[]" multiple>
            <?php foreach($categories as $category):?>
                <option value="<?=$category->getId()?>"><?=$category->getName()?></option>
            <?php endforeach?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
