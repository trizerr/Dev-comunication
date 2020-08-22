<?php


namespace App\Entity;


class Post
{
  private $user_id;
  private $body;

    public function getUserId()
  {
    return $this->user_id;
  }


  private function setUserId($user_id)
  {
    $this->user_id = $user_id;
  }

  public function getBody()
  {
    return $this->body;
  }

  private function setBody($body)
  {
    $this->body = $body;
  }

  public function fromArray($array)
  {
    $this->setUserId($array['user_id']);
    $this->setBody($array['body']);
    return $this;
  }


}