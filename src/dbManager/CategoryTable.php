<?php

namespace App\dbManager;
use App\Pagination;

class CategoryTable extends Table {

  public function findPaginated() {
    $pagination = new Pagination("SELECT * FROM CATEGORIES", "SELECT COUNT(id) FROM CATEGORIES", 'App\Model\Category', "/editing/category", $this->pdo);
    $categories = $pagination->getItems();
    return [$categories, $pagination];
  }

  public function findCategoryById(int $id) {
    $query = $this->pdo->query("SELECT * FROM CATEGORIES WHERE id = :id");
    $query->execute(['id' => $id]);
    $category = $query->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Category')[0];
    return $category;
  }

  public function deleteCategory(int $id) {
    $query = $this->pdo->prepare("DELETE FROM CATEGORIES WHERE id = :id");
    $query->execute(['id' => $id]);
    $query = $this->pdo->prepare("DELETE FROM POSTS_CATEGORIES WHERE id_categorie = :id");
    $query->execute(['id' => $id]);
  }

  public function updateCategory(int $id, string $name) {
    $query = $this->pdo->prepare("UPDATE CATEGORIES SET name = :name WHERE id = :id");
    $query->execute(['name' => $name, 'id' => $id]);
  }

}