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

     $id_emp =$_GET["id"];
     $result = getEmployeesById($id_emp);
     $employees = $result[1];
     $employee = $result[0];

     if($employee==null){
        header("location:404.html");
        return;
     }

     if($employee->isBloque=="1"){
        $employee->isBloque=0;
     }
     else{
        $employee->isBloque=1;
     }

     $employee->update($employees);
     header("location:admin.php");
?>