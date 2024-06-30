<?php

namespace App\dbManager;
use App\Pagination;

class CategoryTable extends Table {
  
  /**
   * findPaginated - Find all categories paginated
   *
   * @return void
   */
  public function findPaginated() {
    $pagination = new Pagination("SELECT * FROM CATEGORIES", "SELECT COUNT(id) FROM CATEGORIES", 'App\Model\Category', "/editing/category", $this->pdo);
    $categories = $pagination->getItems();
    return [$categories, $pagination];
  }
  
  /**
   * findCategoryById - Find a category by its id
   *
   * @param  mixed $id
   * @return void
   */
  public function findCategoryById(int $id) {
    $query = $this->pdo->query("SELECT * FROM CATEGORIES WHERE id = :id");
    $query->execute(['id' => $id]);
    $category = $query->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Category')[0];
    return $category;
  }
  
  /**
   * deleteCategory - Delete a category by its id
   *
   * @param  mixed $id
   * @return void
   */
  public function deleteCategory(int $id) {
    $query = $this->pdo->prepare("DELETE FROM CATEGORIES WHERE id = :id");
    $query->execute(['id' => $id]);
    $query = $this->pdo->prepare("DELETE FROM POSTS_CATEGORIES WHERE id_categorie = :id");
    $query->execute(['id' => $id]);
  }
  
  /**
   * updateCategory - Change the name of a category by its id
   *
   * @param  mixed $id
   * @param  mixed $name
   * @return void
   */
  public function updateCategory(int $id, string $name) {
    $query = $this->pdo->prepare("UPDATE CATEGORIES SET name = :name WHERE id = :id");
    $query->execute(['name' => $name, 'id' => $id]);
  }
  
  /**
   * findAllCategories - Find all categories
   *
   * @return void
   */
  public function findAllCategories() {
    $query = $this->pdo->query("SELECT * FROM CATEGORIES");
    $categories = $query->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Category');
    return $categories;
  }
  
  /**
   * createCategory - Create a new category
   *
   * @param  mixed $name
   * @return void
   */
  public function createCategory(string $name) {
    $query = $this->pdo->prepare("INSERT INTO CATEGORIES (name) VALUES (:name)");
    $query->execute(['name' => $name]);
  }
  
  /**
   * createPostCategory - Create a new link between a post and a category
   *
   * @param  mixed $id_post
   * @param  mixed $id_categorie
   * @return void
   */
  public function createPostCategory(int $id_post, int $id_categorie) {
    $query = $this->pdo->prepare("INSERT INTO POSTS_CATEGORIES (id_post, id_categorie) VALUES (:id_post, :id_categorie)");
    $query->execute(['id_post' => $id_post, 'id_categorie' => $id_categorie]);
  }
  
}