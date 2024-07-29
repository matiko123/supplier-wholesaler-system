<?php
include '../control/connection.php';
session_start();
$admin_id=$_SESSION['admin'];
$query = "SELECT * from admin where id  =$admin_id";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * from plan";
$result1 = mysqli_query($conn, $query1);



while($row= $result->fetch_assoc()) {
$admin_email=$row['email'];
}
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
  $action =$_POST['action'];
  if($action==='addplan'){
    $months=$_POST['months'];
    $price=$_POST['price'];
    $sql="insert into plan (months,price) values('$months','$price')";
    $sql = mysqli_query($conn, $sql);
    header('Location: plans.php');
  }elseif($action==='deleteplan'){
    $plan_id=$_POST['plan_id'];
    $sql="delete from plan where id=$plan_id";
    $sql = mysqli_query($conn, $sql);
    header('Location: plans.php');
  }
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
                    <li class="nav-item item"><a class="nav-link " href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item item"><a class="nav-link active" href="history.php">Subscription plans</a></li>
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
    <label class=" btn btn-outline-primary" style="margin-left:80%"  data-bs-toggle="modal" data-bs-target="#plan">Add Subscription Plan</label></label><br><br>
            <div class="container" >
        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th data-bs-toggle="modal" data-bs-target="#popper">S/NO</th>
                    <th>Plan</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    $i=1;
                    while($row= $result1->fetch_assoc()) {
                      $plan=$row['id'];
                      $month=$row['months'];
                      $price=$row['price'];
                      if($month>11){
                        $month=$month/12;
                        if($month==1){
                          $month="$month year";
                        }else{
                          $month="$month years";
                        }
                      }else{
                        if($month==1){
                          $month=$month." month";
                        }else{
                          $month=$month." months";
                        }
                      }
                    echo "
               <tr>
                    <th>$i</th>
                    <th>$month</th>
                    <th>".number_format($price)."</th>
                    <form method=\"post\">
                    <input type=\"hidden\" name=\"action\" value=\"deleteplan\">
                    <input type=\"hidden\" name=\"plan_id\" value=\"$plan\">
                    <th><button type=\"submit\" class=\"btn btn-outline-danger\">Delete</th>
                    </form>
               </tr> 
                    ";
                    $i++;
                    }

                    ?>

            </tbody>

        </table>
    </div>
</div>

                   <!--Add plans starts-->  
    <div class="modal fade" id="plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="background-color:white">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subscription Plan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
            <input type="hidden" name="action" value="addplan">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Months</label>
                <input type="number" class="form-control" id="recipient-name" name="months" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Price</label>
                <input type="number" class="form-control" id="recipient-name" name="price" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >Add Plan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Add Plans ends-->
                   <!--Popper starts-->  
 <div class="modal fade" id="popper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content bg-dark text-white ">
          <div class="modal-body">
            <form >
            <div class="mb-3">
            <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for Subscription</h1>
                <label for="recipient-name" class="col-form-label">Enter your phone number</label>
                <input type="number" class="form-control" id="recipient-name" name="months" required>
              </div>
<div style="margin-left:70%">
            <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordpopper" aria-label="Close">SEND</button>
</div>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Popper ends-->
 <!--password Popper starts-->  
 <div class="modal fade" id="passwordpopper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content bg-dark text-white ">
          <div class="modal-body">
            <form >
            <div class="mb-3">
            <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for Subscription</h1>
                <label for="recipient-name" class="col-form-label">Enter your passowrd</label>
                <input type="number" class="form-control" id="recipient-name" name="months" required>
              </div>
<div style="margin-left:70%">
            <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#successpopper" >SEND</button>
</div>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- password Popper ends-->
      <!--Transaction complete starts-->  
 <div class="modal fade" id="successpopper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content bg-dark text-white ">
          <div class="modal-body">
            <form >
            <div class="mb-3 text-center">
                <label for="recipient-name" class="col-form-label">Transaction Successful!</label>
              </div>
<div style="margin-left:90%">
            <button type="submit" class="btn btn-secondary btn-sm" >OK</button>
</div>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- transaction complete ends-->

    <!--Table ends-->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/vanilla-zoom.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>