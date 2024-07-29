<?php
include '../control/connection.php';
session_start();
$wholesaler_id=$_SESSION['wholesaler'];

$query1 = "SELECT stock.*,products.name as product from stock inner join products on products.id=stock.product where stock.wholesaler= $wholesaler_id";
$result1 = mysqli_query($conn, $query1);


$query2 = "SELECT * from users where id  =$wholesaler_id";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $wholesaler_name=$row1['name'];
    $phone=$row1['phone'];
    $email=$row1['email'];
    $bio=$row1['bio'];
  }

$query3 = "SELECT * from category";
$result3 = mysqli_query($conn, $query3);

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){

  $action =$_POST['action'];
   if($action==='editprofile'){
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $bio=$_POST['bio'];
    $sql="update users set name='$name',phone='$phone',email='$email',bio='$bio' where id=$wholesaler_id";
    $conn->query($sql);
        header('Location: '.$_SERVER['PHP_SELF']);
    }elseif($action==='sellproduct'){
      $quantity=$_POST['quantity'];
      $barcode=$_POST['barcode'];
      $sql="update stock set quantity=quantity-$quantity where barcode= '$barcode'";
      $conn->query($sql);

      $query2 = "SELECT * from products where barcode ='$barcode'";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $product_id=$row1['id'];
}
      $sql1="insert into sales (wholesaler,product,quantity) values('$wholesaler_id','$product_id','$quantity')";
      $conn->query($sql1);
    
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
    <title>My Stock</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/vanilla-zoom.min.css">
</head>

<body>
    <main class="page landing-page"></main>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#"><?php echo $wholesaler_name ?></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item item"><a class="nav-link active" href="#">My Stock</a></li>
                    <li class="nav-item item"><a class="nav-link" href="sales.php">My Sales</a></li>
                    <li class="nav-item item"><div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                       <div class="btn-group" role="group">
                          <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                               Suppliers
                       </button>
                               <ul class="dropdown-menu">
                                <?php
                               while($row= $result3->fetch_assoc()) {
                                $category_name=$row['category_name'];
                                $category_id=$row['id'];

                                $sql="select count(*) as suppliers  from users where category=$category_id and role=1";
                                $sqlresult=mysqli_query($conn, $sql);
                                while($row1 = $sqlresult->fetch_assoc()) {
                                  $suppliers= $row1['suppliers'];
                                }
                                echo "
                                    <li><a class=\"dropdown-item\" href=\"suppliers.php?category=$category_id\">$category_name ($suppliers)</a></li>
                                   ";
                               }
                                   ?>
                                </ul>
                       </div>
                    </li>
                    <li class="nav-item item"><a class="nav-link" href="history.php">Purchase History</a></li>
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
    <div class="container" style="margin-top: 3cm;margin-bottom: -3cm">

                    <label class=" btn btn-outline-primary btn-sm" style="margin-left: 80%;margin-top: -0.8cm;" data-bs-toggle="modal" data-bs-target="#sellproduct">Sell Product</label>
    </div>
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
        <table class="table my-0 table-hover container shadow-lg" id="dataTable">
            <thead>
                <tr>
                    <th>Product Name </th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
            while($row1= $result1->fetch_assoc()) {
            $product=$row1['product'];    
            $quantity=$row1['quantity'];
            $price=$row1['price'];               
            echo "
            <tr>
                    <td>$product</td>
                    <td>$quantity</td>
                    <td>".number_format($price)."</td>
            </tr>
            ";
            }
            ?>
                
            </tbody>
        </table>
    </div>
   <!--sell product starts-->  
   <div class="modal fade" id="sellproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Sell a product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" >
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Quantity</label>
                <input type="number" class="form-control" id="recipient-name" name="quantity" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Barcode ID</label>
                <input type="hidden" name="action" value="sellproduct">
                <input type="text" class="form-control" id="recipient-name" name="barcode" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >Proceed</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--sell Product ends-->
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
                <input type="text" class="form-control" id="recipient-name" name="name" value="<?php echo $wholesaler_name ?>">
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
     <script>
         if (window.location.href.indexOf('unavailable') !== -1) {
         alert("Couldn't find a product !");
      }
      if (window.location.href.indexOf('insufficient') !== -1) {
         alert("No enough products in store !");
      }
    </script>
</body>

</html>