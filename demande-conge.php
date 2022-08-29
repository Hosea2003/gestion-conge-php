<?php
    session_start();
    if(!isset($_SESSION["group"])){
        header("location:login.php");
    }
    if($_SESSION["group"]=="user"){
        echo "Not authorized";
        return;
    }
    echo "ato";
?>