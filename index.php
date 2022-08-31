<?php
session_start();
include "Model/User.php";
include "Model/Employee.php";
include "Model/Conge.php";

if(!isset($_SESSION["group"])){
    header("location:login.php");
    return;
}
else if($_SESSION["group"]=="admin"){
    header("location:admin.php");
    return;
}
$emp = Employee::getEmployeeByUser($_SESSION["id"]);
$historique = Conge::congeByEmployee($emp->getId());

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <title>Pannel Employé</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><?php echo $emp->getFirstName()." ".$emp->getName()?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Historique congé <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="demander.php">Demander congé</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=<?php echo "update-employee.php?id=".$emp->getId()?>>Modifier profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="change-password.php">Changer mot de passe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deconnexion.php">Déconnecter</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <table class="table table-hover">
            <thead class="thead-dark">
                <th>Date Début</th>
                <th>Date fin</th>
                <th>Etat</th>
                <th>Date d'envoi</th>
            </thead>
            <tbody>
            <?php
                foreach($historique as $conge):
                    $debut = $conge->getDateDebut()->format("d F Y");
                    $fin = $conge->getDateFin()->format("d F Y");
                    $envoi = $conge->getDateEnvoi()->format("d F Y");
                    $status =$conge->getIsAccorde();
                    if($status=="not-seen")$status="En attente";
                    else if($status=="non-accorder")$status="Refusé";
                    else{
                        $today=new DateTime();
                        if($today->getTimestamp()<=$conge->getDateFin()->getTimestamp())$status="En congé";
                        else $status="Accordé";
                    }
            ?>
            <tr>
                <td><?php echo $debut?></td>
                <td><?php echo $fin?></td>
                <td><?php echo $status?></td>
                <td><?php echo $envoi?></td>
            </tr>
            <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</html>
