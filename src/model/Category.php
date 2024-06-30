<?php
namespace App\Model;

/**
 * Category class to define a category
 */
class Category{
  private $id;

  private $name;

  private $slug;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }
}