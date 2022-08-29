<?php
include ("User.php");
function verifyAdmin($admin){
    if(!empty($admin))
        return $admin;
}

function getAdmins(){
    $admins = explode("#", file_get_contents(dirname(__DIR__)."\\Files\\Admin.txt"));
    $admins=array_filter($admins, "verifyAdmin");
    $Admins=array();
    foreach($admins as $admin){
        $admin=explode("~", $admin);
        $Admins[] = new admin($admin[0], $admin[1], getUserByGroup($admin[0], "admin"));
    }
    return $Admins;
}

function getAdminById($id){
    $admins = getAdmins();
    foreach($admins as $admin){
        if($admin->getId()==$id)
            return $admin;
    }
}



    class Admin{
        private $id;
        private $name;
        private $user;

        public function __construct($id, $name, $user){
            $this->id=$id;
            $this->name=$name;
            $this->user = $user;
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id=$id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName($name){
            $this->name=$name;
        }
    }
?>