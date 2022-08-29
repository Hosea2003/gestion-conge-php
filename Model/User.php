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


}