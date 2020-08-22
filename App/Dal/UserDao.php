<?php

namespace App\Dal;

use App\Application;
use App\Entity\User;

class UserDao
{
  public $db;

  public function __construct()
  {
    $this->db = Application::$db;
  }

  public function create(User $user)
  {

        $this->db->query("INSERT INTO users(firstname, lastname, email, username, dob, password) VALUES(
                     :firstname, :lastname, :email, :username, :dob, :password)");

    $this->db->bind('firstname', $user->getFirstName());
    $this->db->bind('lastname', $user->getLastName());
    $this->db->bind('email', $user->getEmail());
    $this->db->bind('username', $user->getUserName());
    $this->db->bind('dob', $user->getDob());
    $this->db->bind('password', $user->getPassword());
    $this->db->execute();
    return true;
  }

    public function read($id)
    {
        $result = $this->db->row("SELECT * FROM users WHERE id = $id");
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['id'] == $id) {
                $user = new User();
                $data = [
                    'firstname' => $result[$i]['firstname'],
                    'lastname' => $result[$i]['lastname'],
                    'email' => $result[$i]['email'],
                    'password' => $result[$i]['password'],
                    'username' => $result[$i]['username'],
                    'dob' => $result[$i]['dob'],
                    'bio' => $result[$i]['bio'],
                    'id' => $id
                ];
                if (file_exists($result[$i]['photo'])) // checking if photo exists
                    $profileimg = $result[$i]['photo'];
                else
                    $profileimg = 'img/default.png'; //if not set to default
                $user->setPhoto($profileimg);
                $user->fromArray($data);
            }
        }
        return $user;
    }

  public function update($data)
  {
      $id=$_SESSION['id'];
      $firstname=$data['firstname'];
      $lastname=$data['lastname'];
      $dob=$data['dob'];
      $username=$data['username'];
      $email=$data['email'];
      $bio=$data['bio'];
      $this->db->query("UPDATE users SET firstname = '$firstname',
                        lastname = '$lastname',
                        dob = '$dob',
                        username = '$username',
                        email = '$email',
                        bio = '$bio'
                        WHERE id = $id");
      $this->db->execute();
  }

    public function updatePass($password){
        $id=$_SESSION['id'];
        $password=md5($password);
        $this->db->query("UPDATE users SET password = '$password' WHERE id = $id");
        $this->db->execute();
    }

  public function delete()
  {

  }

    public function addPicture($photo, $id)
    {
        $this->db->query("UPDATE users SET photo = '$photo' WHERE id = $id");
        $this->db->execute();
    }

    public function search($text)
    {
        $result=null;
        if($text!=null){
            session_start();
            $text=strtolower($text);
            $id=$_SESSION['id'];
            $users = $this->db->row("SELECT * FROM users WHERE id != $id");
            $usercounter=0;
            for ($i = 0; $i < count($users); $i++) {
                $user = $this->read( $users[$i]['id']);
                $userid=$user->getId();


                $username = strtolower($user->getUserName());
                $firstname = strtolower($user->getFirstName());
                $lastname = strtolower($user->getLastName());
                if(substr($username,0, strlen($text))==$text ||
                    substr($firstname,0, strlen($text))==$text ||
                    substr($lastname,0, strlen($text))==$text){
                    $followDao = new FollowDao();
                    $result[$usercounter]['isfollowing'] = $followDao->checkIfFollow($id,$userid);
                    $result[$usercounter]['username'] = $user->getUserName();
                    $result[$usercounter]['firstname'] = $user->getFirstName();
                    $result[$usercounter]['lastname'] = $user->getLastName();
                    $result[$usercounter]['id'] = $user->getId();
                    $result[$usercounter]['photo'] = $user->getPhoto();
                    $usercounter++;
                }
            }
        }
        return $result;
    }
}