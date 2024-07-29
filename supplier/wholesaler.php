<?php
include '../control/connection.php';

session_start();
$supplier_id=$_SESSION['supplier'];

$query1 = "SELECT * FROM users where role=2";
$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT * from users where id  =$supplier_id";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $supplier_name=$row1['name'];
    $phone=$row1['phone'];
    $email=$row1['email'];
    $bio=$row1['bio'];
  }

  if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
      if($action==='editprofile'){
        $name=$_POST['name'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $bio=$_POST['bio'];
        $sql="update users set name='$name',phone='$phone',email='$email',bio='$bio' where id=$supplier_id";
        $conn->query($sql);
            header('Location: '.$_SERVER['PHP_SELF']);
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
      }
 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>History</title>
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
                    <li class="nav-item item"><a class="nav-link" href="index.php">Sales</a></li>
                    <li class="nav-item item"><a class="nav-link active" href="#">Wholesalers</a></li>
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
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search for wholesaler"></label><label class=" btn btn-outline-primary" style="transform:scale(0.83)">search</label></label></div>
                    </div>
                </div>
            </div>
        </center>

        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th>Wholesaler Name</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>View Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php 
            while($row1= $result1->fetch_assoc()) {
           
               $id=$row1['id'];
               $name=$row1['name'];
               $phone=$row1['phone'];
               $location=$row1['location'];
               $sql="select * from stock where wholesaler =$id and quantity<20";
               $result = $conn->query($sql);
               if ($result->num_rows > 0) {
               $label='class="text-danger"';
               $button='btn-outline-danger'; 
                }else{
                    $label='class="text-dark"';
                    $button='btn-outline-primary';  
                }
               echo '
               <tr>
                    <td '.$label.'>'.$name.'</td>
                    <td '.$label.'>'.$phone.'</td>
                    <td '.$label.'>'.$location.'</td>
                     <td><button class="btn '.$button.'"  onclick="location.href=\'wholesaler_stock.php?wholesaler='.$id.'\'">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg>
                   Store </button></td>
                </tr>
               ';
            }
               ?>     
            </tbody>

        </table>
    </div>
 <!--Profile starts-->  
 <div class="modal fade" id="editprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit profile Info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
                <input type="hidden" name="action" value="editprofile">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Name :</label>
                <input type="text" class="form-control" id="recipient-name" name="name" value="<?php echo $supplier_name ?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Phone : </label>
                <input type="number" class="form-control" id="recipient-name" name="phone" value="<?php echo $phone ?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Email :</label>
                <input type="email" class="form-control" id="recipient-name" name="email" value="<?php echo $email?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">bio</label>
                <textarea type="text" class="form-control" id="recipient-name" name="bio" required placeholder="Your self in business career,Your product details,"><?php echo $bio?></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >submit</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Profile ends-->
    <!--Table ends-->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/vanilla-zoom.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>