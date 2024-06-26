<?php
require dirname(__DIR__) . '/../vendor/autoload.php';

$title = 'Mon blog';

$pdo = new PDO('sqlite:'.dirname(__DIR__).'/../data/data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$posts = $pdo->query('SELECT * FROM POSTS ORDER BY created_at DESC LIMIT 16')->fetchAll(PDO::FETCH_CLASS, 'App\Model\Post');

?>
<h1> Mon blog </h1>

<div class="row">
  <?php foreach($posts as $post): ?>
    <div class="col-md-3">
      <?php require 'card.php' ?>
    </div>
  <?php endforeach ?>
</div>