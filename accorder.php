<?php
    include "Model/Conge.php";
    include "Model/Employee.php";
    include "Model/User.php";
    session_start();

    if(!isset($_SESSION["group"])){
        header("location:login.php");
        return;
    }
    if($_SESSION["group"]!="admin"){
        echo "Not authorized";
        return;
    }
    $id=$_GET["id"];
    $result=Conge::getCongeList($id);
    $result[0]->Action($result[1], "accorder");
    header("location:demande-conge.php");
?>