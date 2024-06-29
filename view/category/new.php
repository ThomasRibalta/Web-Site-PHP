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

if (!empty($_POST)) {
    $categoryTable = new CategoryTable(DBManager::pdoConnexion());
    $categoryTable->createCategory($_POST['name']);
    header('Location: /editing/category');
    exit();
}

?>

<h1>New Category</h1>

<form method='post' action="/newCategory">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>