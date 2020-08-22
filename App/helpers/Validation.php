<?php


namespace App\helpers;

use App\Application;
use Core\Database;
class Validation
{
    private $signup = false;
    private $login = false;
    private $updatePass = false;

    /**
     * @return bool
     */
    public function getUpdatePass()
    {
        return $this->updatePass;
    }

    /**
     * @param bool $updatePass
     */
    public function setUpdatePass($updatePass)
    {
        $this->updatePass = $updatePass;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }
    private $db;
    public function isSignup()
    {
        return $this->signup;
    }

    public function setSignup($signup)
    {
        $this->signup = $signup;
    }
    public  function validateLogin($data)
    {
        $data = $this->validateEmail($data);
        if(empty($data['email_err']))
        $data = $this->checkPassword($data);
        if (empty($data['password_err']) && $data['$userloged'])
            $this->setLogin(true);

        return $data;
    }
    public  function validateSignup($data){
        $data = $this->validateDob($data);
        $data = $this->validateUsername($data);
        $data = $this->validateFirstname($data);
        $data = $this->validateLastname($data);
        $data = $this->validateEmail($data);
        $data = $this->checkExistEmail($data);

        if (empty($data['firstname_err']) && empty($data['lastname_err']) && empty($data['email_err']) && empty($data['username_err']) && empty($data['dob_err']) && empty($data['password_err']))
            $this->setSignup(true);

        if(!isset($data['email_err']))
            $data['email_err']=null;
        if(!isset($data['username_err']))
            $data['username_err']=null;
        return $data;
    }

    public static function getId(){
        $db = new Database();
        $result = $db->row("SELECT * FROM users");

        return $result[count($result)-1]['id'];
    }

    public function checkPassword($data){
        $this->db = new Database();
        $result = $this->db->row("SELECT * FROM users");
        $userloged = false;
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['email'] == $data['email']) {
                if ($result[$i]['password'] == $data['password']) {
                  $data['id'] = $result[$i]['id'] ;
                    $data['firstname'] = $result[$i]['firstname'] ;
                    $data['lastname'] = $result[$i]['firstname'] ;
                    $data['username'] = $result[$i]['username'] ;
                    $data['dob'] = $result[$i]['dob'] ;
                    $userloged = true;
                }else{
                    $data['password_err'] ='wrong password';
                }
            }
        }
        $data['$userloged'] = $userloged;
        return $data;
    }

    public function checkExistingPass($password,$data){
        $this->db = new Database();
        $result = $this->db->row("SELECT * FROM users WHERE password = '$password'");
        if($result==null)
            $data['password_err']='wrong pass';
        return $data;
    }
    public function checkExistEmail($data){
        $this->db = new Database();
        $result = $this->db->row("SELECT * FROM users");
        for ($i = 0; $i < count($result); $i++) {
            if(isset($_SESSION['id'])){ //for update
                if($result[$i]['id']!=$_SESSION['id']) {
                    if ($result[$i]['email'] == $data['email']) {
                        $data['email_err'] = 'such email already exists';
                    }
                    if ($result[$i]['username'] == $data['username']) {
                        $data['username_err'] = 'such username already exists';
                    }
                }
            }else {
                if ($result[$i]['email'] == $data['email']) {
                    $data['email_err'] = 'such email already exists';
                }
                if ($result[$i]['username'] == $data['username']) {
                    $data['username_err'] = 'such username already exists';
                }
            }
        }
        return $data;
    }

    public function changePassword($data){
        $data =  $this->checkExistingPass(md5($data['currentPassword']),$data);
        if(!isset($data['password_err'])){
            $this->setUpdatePass(true);
            $data['password_err']="";
        }
       return $data;

    }

    public function validateUsername($data){
        preg_match('/[a-zA-Z0-9]{3,15}/', $data['username'], $matches);
        $matches ? : $data['username_err'] ='Username must be at least three(3) characters long and must can
                 contain one underscore and number';
        return $data;
    }
    public function validateFirstname($data){
        preg_match('/[a-zA-Z]{3,30}/', $data['firstname'], $matches);
        $matches ? : $data['firstname_err'] ='Valid first name is required';
        return $data;
    }
    public function validateLastname($data){
        preg_match('/[a-zA-Z]{3,30}/', $data['lastname'], $matches);
        $matches ? : $data['lastname_err'] ='Valid last name is required';

        return $data;
    }
    public function validateEmail($data){
        preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $data['email'], $matches);
        $matches ? : $data['email_err'] ='Invalid Email';
        return $data;
    }
    public function validateDob($data){
        preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $data['dob'], $matches);
        $matches ? : $data['dob_err'] ='Invalid Date';
        return $data;
    }

}