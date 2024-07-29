<?php
include '../control/connection.php';
session_start();
$supplier_id=$_SESSION['supplier'];

$query1 = "SELECT  history.*,products.name as product,products.price as price,users.name as user from history inner join products on history.product=products.id inner join users on users.id=history.user where products.supplier=$supplier_id";
$result1 = mysqli_query($conn, $query1);

$query1 = "SELECT * from users where id  =$supplier_id";
$result = mysqli_query($conn, $query1);
while($row1 = $result->fetch_assoc()) {
    $supplier_name=$row1['name'];
  }

    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Supplier's Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/vanilla-zoom.min.css">
</head>

<body>
    <main class="page landing-page"></main>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#"><?php echo $supplier_name ?></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                
                    <li class="nav-item item"><a class="nav-link " href="index.php">Purchases</a></li>
                    <li class="nav-item item"><a class="nav-link active" href="#">Sales</a></li>
                    <li class="nav-item item"><a class="nav-link" href="wholesaler.php">Wholesalers</a></li>
                    <li class="nav-item item"><a class="nav-link" href="stock.php">My stock</a></li>
       <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">my Profile</a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;update Profile</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="../index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                            </div>
                    </li>
                    <li class="nav-item item"><a class="nav-link" href="plans.php">Subscription</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Table starts-->

    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
        <center>
            <div class="container" >
                <div class="row container">
                    <div class="col-md-6 text-nowrap">
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search for product"></label><label class=" btn btn-outline-primary" style="transform:scale(0.83)">search</label></label></div>
                    </div>
                </div>
            </div>
        </center>

        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th>Wholesaler Name</th>
                    <th>Product Name</th>
                    <th> Purchased quantity</th>
                    <th> Price</th>
                    <th>Purchased date</th>
                </tr>
                <?php
             $i=1;
            while($row1= $result1->fetch_assoc()) {
            $seller=$row1['user'];
            $product=$row1['product'];
            $price=$row1['price'];
            $quantity=$row1['quantity'];
            $confirmed_date=$row1['transaction_date'];
           
            echo '
                <tr>
                    <td>'.$seller.'</td>
                    <td>'.$product.'</td>
                    <td>'.$quantity.'</td>
                     <td>'.number_format($price*$quantity).'</td>
                    <td>'.$confirmed_date.'</td>
                </tr>
            ';
            }
            ?>
            </thead>
            <tbody>
            
                
            </tbody>

        </table>
    </div>

    <!--Table ends-->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/vanilla-zoom.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>