<?php
    function verifyNotif($n){
        if(!empty($n))return $n;
        return null;
    }

    function getNotif(){
        $notifs = file_get_contents(dirname(__DIR__)."\\Files\\Notif.txt");
        $notifs=explode("#",$notifs);
        $notifs=array_filter($notifs, "verifyNotif");
        $result=array();
        foreach($notifs as $n){
            $n=explode("~", $n);
            $result[]=new Notif($n[0], $n[1]);
        }
        return $result;
    }

    function addNotif($user){
        $notifs=getNotif();
        $today=new DateTime();
        Notif::delete($user);
        file_put_contents(dirname(__DIR__)."\\Files\\Notif.txt", $user->getId()."~".$today->format("Y-m-d")."#", FILE_APPEND);
    }

    class Notif{
        public $user;
        public $date;

        public function __construct($id, $date)
        {
            $this->user=User::getUserById($id);
            $this->date=DateTime::createFromFormat("Y-m-d", $date);
        }

        public static function IsExist($id){
            $notifs = getNotif();
            foreach($notifs as $n){
                if($n->user->getId()==$id)return $n;
            }
            return null;
        }

        public static function delete($user){
            $notifs=getNotif();
            $result="";
            foreach($notifs as $n){
                if($n->user->getId()!=$user->getId())$result.=$user->getId()."~".$n->date->format("Y-m-d")."#";
            }
            file_put_contents(dirname(__DIR__)."\\Files\Notif.txt", $result);
        }
    }
?>