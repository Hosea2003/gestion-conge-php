<?php
    session_start();
    include("Model/Employee.php");

    $first = $_POST["first_name"];
    $name = $_POST["name"];
    $adress = $_POST["address"];

    $employee->setFirstName($first);
    $employee->setName($name);
    $employee->setAddress($adress);

    $employee->update($employees);
    header("location:admin.php");
?>