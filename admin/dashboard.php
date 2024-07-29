<?php
include '../control/connection.php';
session_start();
$admin_id=$_SESSION['admin'];
$query = "SELECT * from admin where id  =$admin_id";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * from plan_history inner join plan on plan.id=plan_history.plan inner join users on plan_history.user=users.id";
$result1 = mysqli_query($conn, $query1);

while($row= $result->fetch_assoc()) {
    $admin_email=$row['email'];
}    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/vanilla-zoom.min.css">
</head>

<body>
    <main class="page landing-page"></main>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#"><?php echo $admin_email ?></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item item"><a class="nav-link" href="category.php">Categories</a></li>
                    <li class="nav-item item"><a class="nav-link" href="plans.php">Subscription plans</a></li>
       <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">my Profile</a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;update Profile</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="../index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                            </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Table starts-->

<div class="container">
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User_Name</th>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Paid_date</th>
                </tr>
            </thead>
            <tbody>
          
                <?php
                $i=1;
            while($row= $result1->fetch_assoc()) {
    $name=$row['name'];
    $plan=$row['months'];
    $price=$row['price'];
    $date=$row['date'];

  echo"
   <tr>
                     <td>$i </td>
                    <td>$name </td>
                    <td>$plan months</td>
                    <td>".number_format($price)."</td>
                    <td>$date</td>
   </tr>
         ";  
        $i++;
     }
                    ?>
            </tbody>

        </table>
    </div>

    <!--Table ends-->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/vanilla-zoom.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>