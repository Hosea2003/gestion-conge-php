<?php
     session_start();
     include("Model/Employee.php");
     include("Model/User.php");

     
     $id_emp =$_GET["id"];
 
     if(!isset($_SESSION["group"])){
         header("location:login.php");
         return;
     }
     if($_SESSION["group"]!="admin" && User::getUserById($_SESSION["id"])->getModel()!=$id_emp){
         echo "Not authorized";
         return;
     }

     $result = getEmployeesById($id_emp);
     $employees = $result[1];
     $employee = $result[0];

     if($employee==null){
         header("location:404.html");
         return;
     }

     if(isset($_POST["register"])){
        $first = $_POST["first_name"];
        $name = $_POST["name"];
        $adress = $_POST["address"];

        $employee->setFirstName($first);
        $employee->setName($name);
        $employee->setAddress($adress);

        $employee->update($employees);
        header("location:index.php");
     }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Modification</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Modification d'un employé!</h1>
                            </div>
                            <form class="user" action=<?php echo "update-employee.php?id=".$employee->getId() ?> method="POST">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name" name="first_name" value=<?php echo $employee->getFirstName()?>>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name" name="name" value=<?php echo $employee->getName()?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleInputAdress"
                                        placeholder="Address" name="address" value=<?php echo $employee->getAddress()?>>
                                </div>
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit" name="register">
                                    Ajouter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>