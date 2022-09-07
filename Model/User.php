<?php

function verify($user){
    if(!empty($user)){
        return  $user;
    }
}

function getUsers(){
    $users = explode("#", file_get_contents(dirname(__DIR__)."\\Files\\User.txt"));
    $users=array_filter($users,"verify");
    $Users=array();
    foreach($users as $u){
        $u=explode("~", $u);
        $Users[] = new User($u[0], $u[1], $u[2], $u[3], $u[4]);
    }
    return $Users;
}


function getUserByGroup($model, $group){
    $users = getUsers();
    foreach ($users as $u){
        if($u->getModel()==$model && $u->getGroup()==$group)
            return $u;
    }
}

class User
{
    private $id;
    private $email;
    private $password;
    private $group;
    private $model;

    /**
     * @param $id
     * @param $email
     * @param $password
     * @param $group
     */
    public function __construct($id, $email, $password, $group, $model)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->group = $group;
        $this->model=$model;
    }

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
    public function setId($id)
    {
        $this->id = $id;
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
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function ToString():string{
        return $this->id."~".$this->email."~".$this->password."~".$this->group."~".$this->model."#";
    }

    public static function add_user(User $user){
        file_put_contents(dirname(__DIR__)."\\Files\\User.txt", "\n".$user->ToString(), FILE_APPEND);
    }

    public static function getNextId():int{
        return count(getUsers())+1;
    }

    public static function getUserById($id){
        $users =getUsers();
        foreach($users as $u){
            if($u->getId()==$id)
                return $u;
        }
        return null;
    }

    public static function getUsersUser($id){
        $users = getUsers();
        foreach($users as $u){
            if($u->getId()==$id){   
                return array(0=>$u, 1=>$users);
            }
        }
        return null;
    }

    public static function getUserByemail($email){
        $users=getUsers();
        foreach($users as $u){
            if($u->getEmail()==$email)return $u;
        }
        return null;
    }

    public function changePassword($new_pass, $users){
        $this->password=$new_pass;
        $content="";
        foreach($users as $u){
            $content.=$u->ToString();
        }
        file_put_contents(dirname(__DIR__)."\\Files\\User.txt", $content);
    }

}