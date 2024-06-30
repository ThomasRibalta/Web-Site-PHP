<?php

namespace App\Model;

/**
 * Post class to define a post
 */
class Post{
  private $id;

  private $title;

  private $slug;

  private $content;

  private $created_at;

  private $categories = [];

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function getCreatedAt(): ?string
  {
    $date_time = date("Y-m-d", $this->created_at);
    return $date_time;
  }

  public function getCategories(): ?array
  {
    return $this->categories;
  }

}