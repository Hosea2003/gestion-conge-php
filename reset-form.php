<?php
    session_start();
    include ("Model/Admin.php");
    include ("Model/Employee.php");
    include ("Model/Notif.php");

    if(!isset($_SESSION["group"])){
        header("location:login.php");
    }
    if($_SESSION["group"]=="user"){
        echo "Not authorized";
        return;
    }
    $admin = getAdminById($_SESSION["id"]);
    $notif=getNotif();
    if(isset($_GET["word"])){
        $notif=array();
        $word = strtolower($_GET["word"]);
        foreach(getNotif() as $n){
            $e=Employee::getEmployeeByUser($n->user->getId());
            if(str_contains(strtolower($e->getFirstName()), $word) || str_contains(strtolower($e->getName()), $word)){
                $notif[]=$n;
            }
        }
    }
    $count=count($notif);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tableau de bord</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Topbar Search -->
                <div>
                    <form action="reset-form.php" method="get"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher employé"
                                aria-label="Search" aria-describedby="basic-addon2" name="word">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="search">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="reset-form.php" class="btn btn-primary">Raffraichir</a>
                </div>
                
                

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin->getName()?></span>
                            <img class="img-profile rounded-circle"
                                 src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-1">
                    <a class="h4 mb-0 text-gray-800" href="admin.php">Tableau de bord</a>
                    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                </div>
                <div class="row">
                    <h1 class="h5"><?php echo $count?> Demandes de reset de mot de passe</h1>
                    
                
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nom de l'employé</th>
                            <th scope="col">Date </th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($notif as $n):
                                $employee = Employee::getEmployeeByUser($n->user->getId());
                                $date=$n->date->format("Y M d");
                                $id=$n->user->getId();
                                $link="reset.php?id=".$n->user->getId();
                        ?>      
                        <tr>
                            <td><?php echo $employee->getFirstName()." ".$employee->getName()?></td>
                            <td><?php echo $date?></td>
                            <td>
                                <a href=<?php echo sprintf("reset.php?id=%d", $id)?> class="btn btn-success">Reset</a>
                            </td>
                        </tr>
                        <?php endforeach?>
                        </tbody>
                    </table>    

                </div>


            </div>
            <!-- /.container-fluid -->

        </div>

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>


</body>