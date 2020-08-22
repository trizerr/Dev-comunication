<?php


namespace Controllers;

use App\Dal\PostDao;
use App\Entity\Post;
use App\helpers\PhotoUpload;
use Core\Controller;
use App\helpers\Params;

class PostController extends Controller
{
  private $postDao;

  public function __construct()
  {
    $this->postDao = new PostDao();
  }

  public function deleteAction()
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postDao->deleteLikes($_POST['id']); //deleting from database
      $this->postDao->delete($_POST['id']);
    }
  }

  public function createAction() // when we create post
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $data = [
        'body' => $_POST['body'],
        'user_id' => $_SESSION['id'],
      ];

      $post = new Post();
      $post = $post->fromArray($data);
      $this->postDao->create($post); // adding post to database
      $postdao = new PostDao();
      $posts = $postdao->renderLast(); //getting last post(just created)
      $who = 'me';
      $params = Params::getParams($posts, $who, $_SESSION['id']); //setting parameters to pass to twig
      $this->render('user/blocks/tweet.twig', $params);
    }

  }

  public function islikedAction()
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $postdao = new PostDao();
      echo $postdao->isLike($_SESSION['id'], $_POST['post_id']);
    }
  }

  public function likeAction()
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $postdao = new PostDao();
      $postdao->like($_SESSION['id'], $_POST['post_id']);
    }
  }

  public function unlikeAction()
  {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $postdao = new PostDao();
      $postdao->unlike($_SESSION['id'], $_POST['post_id']);
    }
  }

  public function getTotalLikesAction()
  { // to get number of likes of the post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $postdao = new PostDao();
      echo $postdao->getTotalLikes($_POST['post_id']);
    }
  }

  public function addImageAction()
  {
    session_start();
    $postDao = new PostDao();
    $posts = $postDao->getTotalPosts();
    $id = $posts[count($posts) - 1]['id'];

    $photo = new PhotoUpload();
    $dir = $photo->postImage($_FILES, $id); //helper to get image
    $postDao->addPicture($dir, $id); //adding image to last post

    $posts = $postDao->renderLast(); //getting last post(just created)
    $who = 'me';
    $params = Params::getParams($posts, $who, $_SESSION['id']); //setting parameters to pass to twig
    $this->render('user/blocks/tweet.twig', $params);
  }

}

