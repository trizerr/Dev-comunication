<?php


namespace Controllers;

use App\Dal\FollowDao;
use App\Dal\UserDao;
use App\helpers\Validation;
use App\helpers\PhotoUpload;
use Core\Controller;
use App\Entity\User;
use Core\SessionAuth;
use App\Dal\PostDao;
use Twig\Error\LoaderError;
use App\helpers\Params;

class UserController extends Controller
{
  private $userDao;

  public function __construct()
  {
    $this->userDao = new UserDao();
  }

  public function loginAction()
  {
      session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user-email'])) {
      $data = [
        'email' => $_POST['user-email'],
        'password' => md5($_POST['user-password']),
        'firstname' => null,
        'lastname' => null,
        'username' => null,
        'id' => null,
        'dob' => null,
          'bio'=>null
      ];

      $validation = new Validation();
      $data = $validation->validateLogin($data);

      if ($validation->getLogin() ) {
          $user = new User();
          $user = $user->fromArray($data);
          SessionAuth::logIn($user);
        if (SessionAuth::isLoggedIn()) {
          header('Location: home');
        } else {
          echo 'Error';
        }
      } else {
        $this->render('user/login.twig', ['error'=>'Invalid Password']);
      }
    } else {
      $this->render('user/login.twig');
    }
  }

  public function registrationAction()
  {
      session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
      $data = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => md5($_POST['password']),
        'dob' => $_POST['dob'],
          'bio' => null,
          'id' => null
      ];

      $validation = new Validation();
      $data = $validation->validateSignup($data);

      if ($validation->isSignup()) {
          $user = new User();
          $user = $user->fromArray($data);
          $this->userDao->create($user);
          $user->setId(Validation::getId());

          SessionAuth::logIn($user);
          if (SessionAuth::isLoggedIn())
              header('Location: home');
      } else {
          $errors = [
              'email_err'=>$data['email_err'],
              'username_err'=>$data['username_err']
          ];
        $this->render('user/registration.twig', $errors);
      }
    } else {
      $this->render('user/registration.twig');
    }

  }

  public function logoutAction()
  {
    session_start();

    SessionAuth::logOut();
  }


  public function homeAction()
  {
    session_start();
    if (SessionAuth::isLoggedIn()) {
        $postdao = new PostDao();
        $posts = $postdao->getTotalPosts();
        $who = 'me';
        $params = Params::getParams($posts,$who,$_SESSION['id']); //setting parameters to pass to twig
      $this->render('user/home.twig',$params);
    } else {
      SessionAuth::requireLogIn();
    }
  }

  public function searchAction()
  {
    session_start();
    if (SessionAuth::isLoggedIn()) {
        $who = 'me';
        $params = Params::getParams(0,$who,$_SESSION['id']);
      $this->render('user/search.twig',$params);
    } else {
      SessionAuth::requireLogIn();
    }
  }

    public function informAction()
    {
        session_start();
        if (SessionAuth::isLoggedIn()) {
            $who = 'me';
            $id = $_SESSION['id'];
            $params = Params::getParams(0, $who, $id); //setting parameters to pass to twig

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {


                $data = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'username' => $_POST['username'],
                    'password'=>null,
                    'dob' => $_POST['dob'],
                    'bio'=>$_POST['bio'],
                    'id' => null
                ];

                $validation = new Validation();
                $data = $validation->validateSignup($data);

                if ($validation->isSignup()) {
                    $user = new User();
                    $user->fromArray($data);
                    $this->userDao->update($data);
                    $params = Params::update('Success!', $data, $id);
                    $this->render('user/inform.twig', $params);
                } else {
                    $params = Params::update('Something went wrong!', $data, $id);
                    $this->render('user/inform.twig', $params);
                }
            }else if(isset($_POST['password'])) {
                $id=$_SESSION['id'];
                $data = [
                    'currentPassword' => $_POST['currentPassword'],
                    'password' => $_POST['password']];

                $validation = new Validation();
                $data=$validation->changePassword($data);

                if ($validation->getUpdatePass()) {
                    $this->userDao->updatePass($data['password']);
                    $params = Params::updatePass('Success!', $data, $id);
                    $this->render('user/inform.twig', $params);
                } else {
                    $params = Params::updatePass('Something went wrong!', $data, $id);
                    $this->render('user/inform.twig', $params);
                }
            }else{
                $this->render('user/inform.twig', $params);
            }

        } else {
            SessionAuth::requireLogIn();
        }
    }

  public function profileAction()
  {
    session_start();
    if (SessionAuth::isLoggedIn()) {
        $postdao = new PostDao();
        $posts = $postdao->getAllPostsByUserId($_SESSION['id']);
        $who='me';
        $params = Params::getParams($posts,$who,$_SESSION['id']); //setting parameters to pass to twig
        $this->render('user/profile.twig',$params);
    } else {
      SessionAuth::requireLogIn();
    }
  }


    public function userProfileAction(){ // when we access other user, url looks like 'twitter/user/34' where 34 is id
        $url = $_SERVER['REQUEST_URI'];
        $urlArray = explode('/',$url);
        $id=$urlArray[2]; //getting id of user
        session_start();
        if (SessionAuth::isLoggedIn()) {
            $postdao = new PostDao();
            $posts = $postdao->getAllPostsByUserId($id);
            if($id==$_SESSION['id']) //checking if that's our page
                $who='me';
            else {
                $who='not me';
            }

            $params = Params::getParams($posts,$who,$id); //setting parameters to pass to twig
            $this->render('user/profile.twig',$params);
        } else {
            SessionAuth::requireLogIn();
        }
    }

    public function uploadPhotoAction()
    {
        session_start();
        $photo = new PhotoUpload();
        $user = new User();
        $userdao = new UserDao();
        $user=$userdao->read($_SESSION['id']);
        $dir=strval($photo->profileImage($_POST["submit"]));
        $user->setPhoto($dir);
        $userdao->addPicture($user->getPhoto(), $_SESSION['id']);
    }

    public function searchingAction(){
        $userdao = new UserDao();
        $users = $userdao->search($_POST['text']);
        //var_dump($users);
        $params = ['users'=>$users,
        'server'=>"http://".$_SERVER['HTTP_HOST'].'/'
        ];

         $this->render('user/blocks/search-result.twig',$params);
    }


}
