<?php 
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\dbManager\DBManager;
use App\Auth;

function need_active(string $name_page, string $link) : string
{
  $current_class = "nav-item";
  if($link === $_SERVER['SCRIPT_NAME'])
      $current_class .= " active";
  return '<li class="' . $current_class . '">
  <a class="nav-link" href="' . $link . '">' . $name_page . '</a>
  </li>';
}

$auth = new Auth(DBManager::pdoConnexion());
$user = $auth->getUser();

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Mon Blog</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?= need_active('Posts', '/posts');?>
            <?= need_active('Categories', '/category');?>
        </ul>
    </div>
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-light" type="submit">Search</button>
    </form>
    <div class="d-flex ms-3">
      <?php if($user): ?>
        <a class="btn btn-outline-light" href="/logout">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light" href="/login">Login</a>
      <?php endif; ?>
  </div>
</nav>