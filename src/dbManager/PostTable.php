<?php
namespace App\dbManager;
use App\Pagination;
use App\Helper\Url;

class PostTable extends Table{

  public function findPaginated() {
    $pagination = new Pagination("SELECT * FROM POSTS ORDER BY created_at DESC", "SELECT COUNT(id) FROM POSTS", 'App\Model\Post', "/", $this->pdo);
    $posts = $pagination->getItems();
    return [$posts, $pagination];
  }

  public function findPostById(int $id, string $slug) {
    $query = $this->pdo->query("SELECT * FROM POSTS WHERE id = :id");
    $query->execute(['id' => $id]);
    $post = $query->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Post')[0];
    Url::is_good_post($post, $slug, $id);
    $query = $this->pdo->query("SELECT c.* FROM CATEGORIES c JOIN POSTS_CATEGORIES pc ON c.id = pc.id_categorie WHERE pc.id_post = :id");
    $query->execute(['id' => $id]);
    $post_categorie = $query->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Category');
    return [$post, $post_categorie];
  }

  public function getPostByCategory(int $id, string $slug) {
    $pagination = new Pagination("SELECT p.* FROM POSTS p JOIN POSTS_CATEGORIES pc ON pc.id_post = p.id WHERE id_categorie=$id", "SELECT COUNT(id_post) FROM POSTS_CATEGORIES WHERE id_categorie=$id", 'App\Model\Post', "/category/$slug-$id");
    $posts = $pagination->getItems();
    $categoryTable = new CategoryTable($this->pdo);
    $category = $categoryTable->findCategoryById($id);
    return [$posts, $pagination, $category];
  }

  public function getPostBySearch(string $search) {
    $pagination = new Pagination("SELECT * FROM POSTS WHERE title LIKE :search", "SELECT COUNT(id) FROM POSTS WHERE title LIKE :search OR content LIKE :search", 'App\Model\Post', "/search?search=$search", $this->pdo);
    $posts = $pagination->getItems();
    return [$posts, $pagination];
  }

  public function deletePost(int $id) {
    $query = $this->pdo->prepare("DELETE FROM POSTS WHERE id = :id");
    $query->execute(['id' => $id]);
    $query = $this->pdo->prepare("DELETE FROM POSTS_CATEGORIES WHERE id_post = :id");
    $query->execute(['id' => $id]);
  }

  public function updatePost(int $id, string $title, string $slug, string $content) {
    $query = $this->pdo->prepare("UPDATE POSTS SET title = :title, slug = :slug, content = :content WHERE id = :id");
    $query->execute(['title' => $title,
                     'slug' => $slug,
                     'content' => $content,
                     'id' => $id]);
  }

  public function createPost(string $title, string $slug, string $content) {
    $query = $this->pdo->prepare("INSERT INTO POSTS (title, slug, content, created_at) VALUES (:title, :slug, :content, :created_at)");
    $query->execute([
        'title' => $title,
        'slug' => $slug,
        'content' => $content,
        'created_at' => time()
    ]);
    $categoryTable = new CategoryTable($this->pdo);
    foreach ($_POST['category'] as $category) {
        $categoryTable->createPostCategory($this->pdo->lastInsertId(), $category);
    }
  }

}
