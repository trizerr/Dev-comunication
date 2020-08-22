<?php


namespace Controllers;


use App\Dal\FollowDao;
use App\helpers\Params;
use Core\Controller;

class FollowerController extends Controller
{
    private $followDao;

    public function __construct()
    {
        $this->followDao = new FollowDao();
    }

    public function followAction(){
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $followdao = new FollowDao();
            $followdao->follow($_SESSION['id'], $_POST['user_id']);
        }
    }

    public function unfollowAction(){
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->followDao->unfollow($_SESSION['id'], $_POST['user_id']);
        }
    }
/*
    public function getTotalFollowersAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $this->followDao->getTotalFollowersByUserId($_POST['user_id']);
        }
    }

    public function getTotalFollowingAction(){
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $following=$this->followDao->getTotalFollowingByUserId($_POST['user_id']);
            $who = "me";
            $params = Params::getParams(null,$who,$_SESSION['id']);
            $this->render('user/blocks/tweet.twig',$params);
        }
    }*/

}