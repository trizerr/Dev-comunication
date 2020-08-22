<?php


namespace App\Dal;

use App\Application;
use App\Entity\Post;
use app\models\User;

class PostDao
{
  private $db;

  public function __construct()
  {
    $this->db = Application::$db;
  }

  public function create(Post $post)
  {
    $this->db->query("INSERT INTO posts (user_id, body) VALUES (:user_id, :body)");
    $this->db->bind('user_id',$post->getUserId() );
    $this->db->bind('body', $post->getBody());
    $this->db->execute();
    return true;
  }

  public function read($postsdb) //function to read posts which are selected in $postsdb
  {                              //using in all postdao methods
      $posts = null;
      for ($i = 0; $i < count($postsdb); $i++) {
          $userdao = new UserDao();
          $user = $userdao->read($postsdb[$i]['user_id']); // create user of current post

          $posts[$i]['username'] = $user->getUserName();
          $posts[$i]['firstname'] = $user->getFirstName();
          $posts[$i]['lastname'] = $user->getLastName();

          if (file_exists($user->getPhoto())) //check if photo exists
              $posts[$i]['photo'] = $user->getPhoto();
          else
              $posts[$i]['photo'] =""; //if not, set to null

          $posts[$i]['user_id'] = $postsdb[$i]['user_id']; // setting params to pass to twig
          $posts[$i]['body'] = $postsdb[$i]['body'];
          $posts[$i]['id'] = $postsdb[$i]['id'];
          $posts[$i]['created_at'] = $postsdb[$i]['created_at'];

          if (file_exists($postsdb[$i]['image'])) //check if post image exists
              $posts[$i]['image'] = $postsdb[$i]['image'];
          else
              $posts[$i]['image'] = "";

          if($posts[$i]['user_id'] == $_SESSION['id']){ // check if I am the author
              $posts[$i]['author'] = "me";
          } else{
              $posts[$i]['author'] = "not me";
          }
      }
      return $posts;
  }

  public function readAll(array $searchFields)
  {
    // TODO: Implement readAll() method.
  }

  public function update(Post $post)
  {
    // TODO: Implement update() method.
  }

  public function delete($id)
  {
      $this->db->query("DELETE FROM posts WHERE id = $id"); //delete post from database
      $this->db->execute();
  }
    public function deleteLikes($id)
    {
        $this->db->query("DELETE FROM likes WHERE post_id = $id"); //delete likes of this post from database
        $this->db->execute();
    }

  public function renderLast() // render last post ( when clicking tweet )
  {
      $postsdb = $this->db->row("SELECT * FROM posts ORDER BY ID DESC LIMIT 1"); // get last post from database
      return $this->read($postsdb);
  }

  public function getAllPostsByUserSession($session)
  {
  }

  public function getAllPostsByUserId($id) // get posts by user id to see on other user's profile page
  {
      $posts=null;
      $postsdb = $this->db->row("SELECT * FROM posts  WHERE user_id = $id");
      return $this->read($postsdb);

  }

  public function post($body)
  {

  }

    public function getTotalPosts()
  {
      $posts=null;
      $postsdb = $this->db->row("SELECT * FROM posts");
      return $this->read($postsdb);

  }

  public function getTotalPostsByUserName($username)
  {
  }

  public function like($user_id, $post_id)
  {
      $this->db->query("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
      $this->db->bind('user_id',$user_id );
      $this->db->bind('post_id',$post_id );
      $this->db->execute();
  }

  public function unlike($user_id, $post_id)
  {
      $this->db->row("DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");
  }

  public function isLike($user_id, $post_id)
  {
      $like = $this->db->row("SELECT * FROM likes WHERE user_id = $user_id AND  post_id = $post_id ");
      if($like!=null)
        return true;
      return false;
  }

  public function getTotalLikes($post_id)
  {
      $likes = $this->db->row("SELECT * FROM likes WHERE post_id = $post_id");
      return count($likes);
  }

    public function addPicture($photo, $post_id)
    {
        $this->db->query("UPDATE posts SET image = '$photo' WHERE id = $post_id");
        $this->db->execute();
    }
}