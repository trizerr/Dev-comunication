<?php


namespace App\helpers;


use App\Dal\FollowDao;
use App\Dal\PostDao;
use App\Dal\UserDao;
use App\Entity\User;

class Params
{
  public static function getParams($posts, $who, $id)
  { // helper to set variables for twig
    $userdao = new UserDao();
    $user = new User();
    $user = $userdao->read($id);
    $followDao = new FollowDao();
    $follow = null;
    $following = $followDao->getTotalFollowingByUserId($id);
    $followers = $followDao->getTotalFollowersByUserId($id);
    $recomendations = $followDao->getRecommendations($_SESSION['id']);
      $postdao = new PostDao();
      $myposts = $postdao->getAllPostsByUserId($_SESSION['id']);
    if ($who == "not me") { //for button
      $isfollowed = $followDao->isFollow($_SESSION['id'], $id);
      if ($isfollowed)
        $follow = 'Following';
      else
        $follow = 'Follow';
    }

    //  echo $follow;
    $params = [
        'myposts'=>$myposts,
      'posts' => $posts,
      'following' => $following,
      'followers' => $followers,
        'recomendation'=>$recomendations,
      'who' => $who,
      'server' => "http://" . $_SERVER['HTTP_HOST'] . '/',
      'photo' => $user->getPhoto(),
      'followbutton' => $follow,
      'id' => $id,
        'email' =>$user->getEmail(),
        'dob' =>$user->getDob(),
        'bio' =>$user->getBio(),
      'username' => $user->getUserName(),
      'firstname' => $user->getFirstName(),
      'lastname' => $user->getLastName(),
      'name' => $user->getFirstName() . ' ' . $user->getLastName(),
    ];
    return $params;
  }

  public static function update($result,$data,$id){
      $userdao = new UserDao();
      $user = $userdao->read($id);
      $followDao = new FollowDao();
      $follow = null;
      $following = $followDao->getTotalFollowingByUserId($id);
      $followers = $followDao->getTotalFollowersByUserId($id);
      $postdao = new PostDao();
      $myposts = $postdao->getAllPostsByUserId($_SESSION['id']);

      $params = [
          'myposts'=>$myposts,
          'following' => $following,
          'followers' => $followers,
          'who' => 'me',
          'server' => "http://" . $_SERVER['HTTP_HOST'] . '/',
          'photo' => $user->getPhoto(),
          'id' => $id,
          'email' =>$user->getEmail(),
          'dob' =>$user->getDob(),
          'bio' =>$user->getBio(),
          'username' => $user->getUserName(),
          'firstname' => $user->getFirstName(),
          'lastname' => $user->getLastName(),
          'email_err' => $data['email_err'],
          'username_err' => $data['username_err'],
          'result'=>$result,
          'name' => $user->getFirstName() . ' ' . $user->getLastName()
      ];
      return $params;
  }

  public static function updatePass($result,$data,$id){
      $userdao = new UserDao();
      $user = $userdao->read($id);
      $followDao = new FollowDao();
      $follow = null;
      $following = $followDao->getTotalFollowingByUserId($id);
      $followers = $followDao->getTotalFollowersByUserId($id);
      $postdao = new PostDao();
      $myposts = $postdao->getAllPostsByUserId($_SESSION['id']);

      $params = [
          'myposts'=>$myposts,
          'following' => $following,
          'followers' => $followers,
          'who' => 'me',
          'server' => "http://" . $_SERVER['HTTP_HOST'] . '/',
          'photo' => $user->getPhoto(),
          'id' => $id,
          'email' =>$user->getEmail(),
          'dob' =>$user->getDob(),
          'bio' =>$user->getBio(),
          'username' => $user->getUserName(),
          'firstname' => $user->getFirstName(),
          'lastname' => $user->getLastName(),
          'password_err' => $data['password_err'],
          'result'=>$result,
          'name' => $user->getFirstName() . ' ' . $user->getLastName()
      ];
      return $params;

  }
}

