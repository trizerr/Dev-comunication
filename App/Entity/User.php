<?php

namespace App\Entity;

class User
{
  private $firstName;
  private $lastName;
  private $userName;
  private $email;
  private $dob;
  private $password;
  private $bio;
  private $photo;

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
  private $id;

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id): void
  {
    $this->id = $id;
  }



  /**
   * @return mixed
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   * @param mixed $firstName
   */
  public function setFirstName($firstName): void
  {
    $this->firstName = $firstName;
  }

  /**
   * @return mixed
   */
  public function getLastName()
  {
    return $this->lastName;
  }

  /**
   * @param mixed $lastName
   */
  public function setLastName($lastName): void
  {
    $this->lastName = $lastName;
  }

  /**
   * @return mixed
   */
  public function getUserName()
  {
    return $this->userName;
  }

  /**
   * @param mixed $userName
   */
  public function setUserName($userName): void
  {
    $this->userName = $userName;
  }

  /**
   * @return mixed
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email): void
  {
    $this->email = $email;
  }

  /**
   * @return mixed
   */
  public function getDob()
  {
    return $this->dob;
  }

  /**
   * @param mixed $dob
   */
  public function setDob($dob): void
  {
    $this->dob = $dob;
  }

  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @param mixed $password
   */
  public function setPassword($password): void
  {
    $this->password = $password;
  }

  /**
   * @return mixed
   */
  public function getBio()
  {
    return $this->bio;
  }

  /**
   * @param mixed $bio
   */
  public function setBio($bio): void
  {
    $this->bio = $bio;
  }



  public function fromArray ($array) {
    $this->setFirstName($array['firstname']);
    $this->setLastName($array['lastname']);
    $this->setUserName($array['username']);
    $this->setEmail($array['email']);
    $this->setPassword($array['password']);
    $this->setDob($array['dob']);
    $this->setId($array['id']);
    $this->setBio($array['bio']);
    return $this;
  }

}