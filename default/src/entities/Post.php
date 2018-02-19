<?php

namespace pdoblog\entities;

class Post {
  private $id;
  private $title;
  private $article;
  private $id_user;

  public function __construct(string $title,
                              string $article,
                              int $id_user=null,
                              int $id=null) {
  $this->id = $id;
  $this->title = $title;
  $this->article = $article;
  $this->id_user = $id_user;
  }

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of article
   */
  public function getArticle()
  {
    return $this->article;
  }

  /**
   * Set the value of article
   *
   * @return  self
   */
  public function setArticle($article)
  {
    $this->article = $article;

    return $this;
  }

  /**
   * Get the value of id_user
   */
  public function getId_user()
  {
    return $this->id_user;
  }

  /**
   * Set the value of id_user
   *
   * @return  self
   */
  public function setId_user($id_user)
  {
    $this->id_user = $id_user;

    return $this;
  }
}