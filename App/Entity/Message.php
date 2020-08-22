<?php


namespace App\Entity;


class Message
{
  private $user_id;
  private $receiver_id;
  private $text;

  /**
   * @return mixed
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * @param mixed $user_id
   */
  public function setUserId($user_id): void
  {
    $this->user_id = $user_id;
  }

  /**
   * @return mixed
   */
  public function getReceiverId()
  {
    return $this->receiver_id;
  }

  /**
   * @param mixed $receiver_id
   */
  public function setReceiverId($receiver_id): void
  {
    $this->receiver_id = $receiver_id;
  }

  /**
   * @return mixed
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * @param mixed $text
   */
  public function setText($text): void
  {
    $this->text = $text;
  }


  public function fromArray($array)
  {
    $this->setUserId($array['user_id']);
    $this->setText($array['text']);
   // $this->setReceiverId($array['receiverName']);
    return $this;
  }
}