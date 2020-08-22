<?php


namespace App\Dal;


use App\Application;

class FollowDao
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$db;
    }

    public function follow($follower_id, $following_id){
        $this->db->query("INSERT INTO subscriptions(follower_id, following_id) VALUES(
                     :follower_id, :following_id)");
        $this->db->bind('follower_id',$follower_id );
        $this->db->bind('following_id',$following_id );
        $this->db->execute();
    }

    public function unfollow($follower_id, $following_id){
        $this->db->row("DELETE FROM subscriptions WHERE follower_id = $follower_id AND following_id = $following_id");
    }

    public function findFollow($follower_id, $following_id){}

    public function isFollow($follower_id, $following_id){
        $check = $this->db->row("SELECT * FROM subscriptions WHERE follower_id = $follower_id AND  following_id = $following_id ");
        if($check==null)
            return false;
        return true;
    }

   /* public function getTotalFollowing($id){
        $result = $this->db->row("SELECT * FROM subsriptions WHERE follower_id = $id");
        for ($i = 0; $i < count($result); $i++) {
                $user = new User();
                $data = [
                    'firstname' => $result[$i]['firstname'],
                    'lastname' => $result[$i]['lastname'],
                    'email' => $result[$i]['email'],
                    'password' => $result[$i]['password'],
                    'username' => $result[$i]['username'],
                    'dob' => $result[$i]['dob'],
                    'id' => $id
                ];
                if (file_exists($result[$i]['photo'])) // checking if photo exists
                    $profileimg = $result[$i]['photo'];
                else
                    $profileimg = 'img/default.png'; //if not set to default
                $user->setPhoto($profileimg);
                $user->fromArray($data);
        }
        return $user;
    }*/

    public function getTotalFollower(){}

    public function checkIfFollow($id,$userid){

        $FollowThisUser = $this->db->row("SELECT * FROM subscriptions
            WHERE follower_id = $id AND following_id = $userid"); //checking if I follow this User

        if ($FollowThisUser == null)
            $result = 'Follow';
        else
            $result = 'Following';
        return $result;
    }

    public function getTotalFollowingByUserId($id)
    {
        $followingdb = $this->db->row("SELECT * FROM subscriptions WHERE follower_id = $id");
        $following = null;
        for ($i = 0; $i < count($followingdb); $i++) {
            $userdao = new UserDao();
            $user = $userdao->read($followingdb[$i]['following_id']);
            $userid = $user->getId();



            $userFollowingMe = true;
            $following[$i]['id'] = $user->getId();
            $following[$i]['firstname'] = $user->getFirstName();
            $following[$i]['lastname'] = $user->getLastName();
            $following[$i]['photo'] = $user->getPhoto();
            $following[$i]['username'] = $user->getUserName();
            $following[$i]['isfollowing'] = "Following";
        }
        return $following;
    }

    public function getTotalFollowersByUserId($id){
        $followersdb = $this->db->row("SELECT * FROM subscriptions WHERE following_id = $id");
        $followers=null;
        for ($i = 0; $i < count($followersdb); $i++) {
            $userdao = new UserDao();
            $user = $userdao->read($followersdb[$i]['follower_id']);
            $userid = $user->getId();
            $followers[$i]['id']=$user->getId();
            $followers[$i]['firstname']=$user->getFirstName();
            $followers[$i]['lastname']=$user->getLastName();
            $followers[$i]['photo']=$user->getPhoto();
            $followers[$i]['username']=$user->getUserName();
            $followers[$i]['isfollowing']=$this->checkIfFollow($id,$userid);
            $followers[$i]['followers']='followers';//kostyl' don't pay attention
        }
        return $followers;
    }

    public function getRecommendations($id){
        $usersdb= $this->db->row("SELECT * FROM users WHERE id != $id");

        $recommendations=null;
        $counter=0;
        for ($i = 0; $i < count($usersdb); $i++) {
            $userid = $usersdb[$i]['id'];
            $userdao = new UserDao();
            $user = $userdao->read($usersdb[$i]['id']);
            $isfollowing = $this->db->row("SELECT * FROM subscriptions WHERE follower_id = $id AND following_id = $userid");
            if($isfollowing == null){
                $recommendations[$counter]['id']=$user->getId();
                $recommendations[$counter]['firstname']=$user->getFirstName();
                $recommendations[$counter]['lastname']=$user->getLastName();
                $recommendations[$counter]['photo']=$user->getPhoto();
                $recommendations[$counter]['username']=$user->getUserName();
                $recommendations[$counter]['isfollowing']=$this->checkIfFollow($id,$userid);
                $counter++;
            }

        }
        return $recommendations;

    }

    public function getFollowingByUserName($username){}

    public function getFollow($id){}

    public function getFollowersByUserName($username){}
}