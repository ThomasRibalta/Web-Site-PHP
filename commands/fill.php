<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = new PDO('sqlite:'.dirname(__DIR__).'/data/data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$faker = Faker\Factory::create('fr_FR');

// CLEAR ALL TABLES
$pdo->exec('DELETE FROM USERS');
$pdo->exec('DELETE FROM RANKS');
$pdo->exec('DELETE FROM POSTS');
$pdo->exec('DELETE FROM CATEGORIES');
$pdo->exec('DELETE FROM POSTS_CATEGORIES');

// RESET AUTOINCREMENT
$pdo->exec('DELETE FROM sqlite_sequence');

$post_ids = [];
$category_ids = [];

// ADD RANDOM 50 POSTS
for ($i = 0; $i < 50; $i++){
  $title = $faker->sentence(3);
  $slug = $faker->slug();
  $created_at = $faker->unixTime();
  $content = $faker->paragraphs(rand(3, 15), true);

  $statement = $pdo->prepare("INSERT INTO POSTS (title, slug, content, created_at) VALUES (:title, :slug, :content, :created_at)");
  $statement->execute([
      ':title' => $title,
      ':slug' => $slug,
      ':content' => $content,
      ':created_at' => $created_at
  ]);
  $post_ids[] = $pdo->lastInsertId();
}

// ADD RANDOM 5 CATEGORIES
for ($i = 0; $i < 5; $i++){
  $name = $faker->sentence(2);
  $slug = $faker->slug();

  $statement = $pdo->prepare("INSERT INTO CATEGORIES (name, slug) VALUES (:name, :slug)");
  $statement->execute([
      ':name' => $name,
      ':slug' => $slug
  ]);
  $category_ids[] = $pdo->lastInsertId();
}

// ADD CATEGORIES TO POST RANDOMLY WITH ID
foreach($post_ids as $post_id){
  $randomCategories = $faker->randomElements($category_ids, rand(0, count($category_ids)));
  foreach($randomCategories as $category_id){
    $statement = $pdo->prepare("INSERT INTO POSTS_CATEGORIES (id_post, id_categorie) VALUES (:id_post, :id_categorie)");
    $statement->execute([
        ':id_post' => $post_id,
        ':id_categorie' => $category_id
    ]);
  }
}

// CREATE USER/RANK
$username = 'admin';
$password = password_hash('admin', PASSWORD_BCRYPT);
$statement = $pdo->prepare("INSERT INTO USERS (username, password, rank_id) VALUES (:username, :password, :rank_id)");
$statement->execute([
    ':username' => $username,
    ':password' => $password,
    ':rank_id' => 1
  ]);

$rankname = 'admin';
$statement = $pdo->prepare("INSERT INTO RANKS (rank_name) VALUES (:name)");
$statement->execute([
    ':name' => $rankname
  ]);
