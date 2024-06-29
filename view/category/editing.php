<?php
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
use App\Helper\Url;
use App\Pagination;
use App\dbManager\CategoryTable;

$auth = new Auth(DBManager::pdoConnexion());
if ($auth->requireRole('1')) {
    header('Location: /login');
    exit();
}

$pdo = DBManager::pdoConnexion();
$edit = Url::getIntValue('edit', true);
$delete = Url::getIntValue('delete', true);
$categoryTable = new CategoryTable($pdo);

if (isset($_POST['name']))
{
  $categoryTable->updateCategory($edit, $_POST['name']);
  header('Location: /editing/category');
  exit();
}
[$categories, $pagination] = $categoryTable->findPaginated();

if ($delete !== 0)
{
  $categoryTable->deleteCategory($delete); 
  header('Location: /editing/category');
  exit();
}

?>
<div class="d-flex justify-content-between">
<h1> Editing Category</h1>
<a href="/editing/post" class="btn btn-primary h-100">Post</a>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Button</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($categories as $category):?>
    <?php if ($category->getId() === $edit):?>
        <form method="post">
          <tr>
          <th scope="col"><?=$category->getId()?></th>
          <th scope="col"><input type="text" class="form-control" name="name" placeholder="" value="<?=$category->getName()?>"></th>
          <th scope="col">
            <div>
              <button type="submit" class="btn btn-warning">Update</button>
              <a href="/editing/category" class="btn btn-danger">Cancel</a>
            </div>
          </th>
          </tr>
        </form>
    <?php else:?>
      <tr>
      <th scope="col"><?=$category->getId()?></th>
      <th scope="col"><?=$category->getName()?></th>
      <th scope="col">
        <div>
          <a href="/category/<?=$category->getSlug()?>-<?=$category->getId()?>" class="btn btn-primary">Show</a>
          <a href="/editing/category?edit=<?=$category->getId()?>" class="btn btn-warning">Edit</a>
          <a href="/editing/category?delete=<?=$category->getId()?>" class="btn btn-danger">Delete</a>
        </div>
      </th>
      </tr>
    <?php endif?>
    <?php endforeach?>
  </tbody>
</table>

<a href="#" class="btn btn-primary">Create a new category</a>

<?= $pagination->getPageNumberList() ?>
