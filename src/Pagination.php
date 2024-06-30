<?php
namespace App;
use \PDO;
use \App\Helper\Url;
use \App\dbManager\DBManager;

class Pagination{

  private $pdo;
  private $query;
  private $queryCount;
  private $className;
  private $perPage;
  private $default;
  private $pages;

  public function __construct(string $query, string $queryCount, string $className, string $defaultUrl, PDO $pdo = null, int $perPage = 16){
    $this->pdo = $pdo ?? DBManager::pdoConnexion();
    $this->perPage = $perPage;
    $this->query = $query . " LIMIT $perPage";
    $this->queryCount = $queryCount;
    $this->className = $className;
    $this->default = $defaultUrl;
  }
  
  /**
   * getOffset - Get the offset for the query
   *
   * @return int
   */
  public function getOffset(): int{
    $count = $this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0];
    $nPage = Url::getIntValue('page');
    $this->pages = ceil($count / $this->perPage);
    if ($nPage > $this->pages) {
      header("Location: $this->default");
      exit();
    }
    $offset = $this->perPage * ($nPage - 1);
    return $offset;
  }
  
  /**
   * getItems - Get the items for the query
   *
   * @return array
   */
  public function getItems(): array{
    $offset = $this->getOffset();
    $this->query .= " OFFSET $offset";
    $query = $this->pdo->query($this->query);
    $posts = $query->fetchAll(PDO::FETCH_CLASS, $this->className);
    return $posts;
  }
  
  /**
   * getPageNumberList - Get the page number list
   *
   * @return string
   */
  public function getPageNumberList(): string{
    $nPage = Url::getIntValue('page');
    $html = '';
    for ($i = 1; $i <= $this->pages; $i++) {
      $html .= "<a href='?page=$i' class='btn ";
      $html .= ($nPage === $i) ? "btn-primary" : "btn-secondary";
      $html .= "'>$i</a>";
    }
    return $html;
  } 
}