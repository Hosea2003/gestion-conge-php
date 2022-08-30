<?php
    session_start();
    include("Model/Employee.php");
    include("Model/User.php");
    include("Model/Conge.php");

    if(!isset($_SESSION["group"])){
        header("location:login.php");
        return;
    }
    if($_SESSION["group"]=="admin"){
        echo "Not authorized";
        return;
    }
    foreach(getEmployees() as $e){
        if($e->getUser()->getId()==$_SESSION["id"]){
            $emp=$e;
            break;
        }
    }
    echo $emp->getName();
    $today= new DateTime();

    if(isset($_POST["submit"])){
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
    <title>Demander congés</title>
</head>
<body>
    <form action="demander.php" method="POST">
        <input type="date"
            id="datePicker" name="datePicker"
            value="2021-03-22"
            min="2001-01-01" max="2099-12-31">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script>
    
</script>
</html>