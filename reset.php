<?php
    session_start();
    include ("Model/Notif.php");
    include ("Model/User.php");

    if(!isset($_SESSION["group"])){
        header("location:login.php");
    }
    if($_SESSION["group"]=="user"){
        echo "Not authorized";
        return;
    }

    if(isset($_GET["id"])){
        $users=User::getUsersUser($_GET["id"]);
        $users[0]->changePassword("1234", $users[1]);
        Notif::delete($users[0]);
        header("location:reset-form.php");
    }
?>