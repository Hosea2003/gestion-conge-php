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
    $emp = Employee::getEmployeeByUser($_SESSION["id"]);
    $today= new DateTime();

    if(isset($_POST["ask"])){
        $debut=DateTime::createFromFormat("j F, Y", $_POST["from_date"]);
        $fin=DateTime::createFromFormat("j F, Y", $_POST["to_date"]);
        $motif= $_POST["motif"];
        Conge::add_conge(new Conge($emp->getId(), $debut->format("Y-m-d"), $fin->format("Y-m-d"), "not-seen", $emp, $today->format("Y-m-d"), Conge::getNextId()));
        header("location:index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    
    <link rel="stylesheet" href="css/classic.css">
    <link rel="stylesheet" href="css/classic.date.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Demander congé</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Profil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Historique congé <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="demander.php">Demander congé</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Modifier profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Paramètre compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deconnexion.php">Déconnecter</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

  <div class="content">
    
    <div class="container text-left">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <h2 class="mb-5 text-center">Demander à prendre un congé</h2>
          <form action="demander.php" class="user" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="input_from">Commence</label>
                    <input type="text" class="form-control" id="input_from" placeholder="Start Date" name="from_date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="input_to">Se termine</label>
                    <input type="text" class="form-control" id="input_to" placeholder="End Date" name="to_date">
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="text" placeholder="Motif" class="form-control mb-3" name="motif">
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-primary" type="submit" name="ask">Demander</button>
                </div>
            </div>
            
          </form>
        </div>
      </div>
          
    </div>
  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>

    <script src="js/main.js"></script>
  </body>
</html>