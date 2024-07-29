<?php
session_start();
$wholesaler_id=$_SESSION['wholesaler'];
include '../control/connection.php';
$supplier_id=$_GET['supplier'];
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='addproduct'){
      $quantity=$_POST['quantity'];
      $barcode=$_POST['barcode'];
      $product_id=$_POST['product_id'];
      $confirmed_date=date('Y-m-d H:i:s');

        $query1 = "SELECT * from stock where product=$product_id";
        $result = mysqli_query($conn, $query1);
        while($row1 = $result->fetch_assoc()) {
            $stock_id=$row1['id'];
          }
        if ($result->num_rows > 0){
            $sql="update stock set quantity=quantity+$quantity where id=$stock_id ";
            $sql = mysqli_query($conn, $sql);
            $sql1="insert into history (product,quantity,user) values ('$product_id','$quantity','$wholesaler_id')";
            $sql1 = mysqli_query($conn, $sql1);
            $sql2="update products set quantity=quantity-$quantity where id=$product_id ";
            $sql2 = mysqli_query($conn, $sql2);
            header('Location: history.php');
        }else{
            $sql="insert into stock (wholesaler,product,quantity,barcode) values ('$wholesaler_id','$product_id','$quantity','$barcode')";
            $sql = mysqli_query($conn, $sql);
            $sql1="insert into history (product,quantity,user) values ('$product_id','$quantity','$wholesaler_id')";
            $sql1 = mysqli_query($conn, $sql1);
            $sql2="update products set quantity=quantity-$quantity where id=$product_id ";
            $sql2 = mysqli_query($conn, $sql2);
            header('Location: history.php');
        }
      }
      }

      $query1 = "SELECT * FROM products where supplier=$supplier_id";
      $result1 = mysqli_query($conn, $query1);

      $query2 = "SELECT * from users where id  =$wholesaler_id";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $wholesaler_name=$row1['name'];
  }
  $query3 = "SELECT * from category";
$result3 = mysqli_query($conn, $query3);
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
        <div class="container"><a class="navbar-brand logo" href="#"><?php echo $wholesaler_name?></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item item"><a class="nav-link " href="index.php">My Stock</a></li>
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
                                echo "
                                    <li><a class=\"dropdown-item\" href=\"suppliers.php?category=$category_id\">$category_name</a></li>
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

    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
        <table class="table my-0 table-hover container shadow-lg" id="dataTable">
            <thead>
                <tr> 
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Request</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
            while($row1= $result1->fetch_assoc()) {
        $product=$row1['id'];
        $supplier=$row1['supplier'];
        $name=$row1['name'];
        $quantity=$row1['quantity'];
        $price=$row1['price'];
        $barcode=$row1['barcode'];
      echo "
                <tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>".number_format($price)."</td>
                    <td><button class=\"btn btn-outline-primary\"  data-bs-toggle=\"modal\" data-bs-target=\"#quantity$i\">Select</button></td>
                </tr>
";
echo '
             <!--quantity starts-->  
                    <div class="modal fade" id="quantity'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                               <form method="post" action="addstock.php">
                               <div class="mb-3">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for '.$name.'</h1>
                                   <label for="recipient-name" class="col-form-label">Enter Quantity</label>
                                   <input type="number" class="form-control" id="recipient-name" name="quantity">
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                               <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#means'.$i.'" aria-label="Close">SEND</button>
                   </div>
                             </div>
                            
                           </div>
                         </div>
                       </div>
                       <!--Quantity ends-->

                    <!--Popper starts-->  
                    <div class="modal fade" id="means'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                       
                               <div class="mb-3" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#popper'.$i.'">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Select Payment Method for '.$name.'</h1><br><br>
                                   <img src="../img/airtel.png" class="img-thumbnail" style="width:60px;height:60px;" alt="..." > Airtel Money <br><br>
                                   <img src="../img/tigo.jpeg" class="img-thumbnail" style="width:60px;height:60;" alt="..."> Tigo Pesa <br><br>
                                   <img src="../img/voda.png" class="img-thumbnail" style="width:60px;height:60px;" alt="..."> M-Pesa<br><br>
                                   <img src="../img/halo.png" class="img-thumbnail" style="width:60px;height:60px;" alt="..."> Halopesa<br>
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                   </div>
                             </div>
                         
                           </div>
                         </div>
                       </div>
                       <!--Popper ends-->


                    <!--Popper starts-->  
                    <div class="modal fade" id="popper'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                             
                               <div class="mb-3">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for '.$name.'</h1>
                                   <label for="recipient-name" class="col-form-label">Enter 8 digits merchant number</label>
                                   <input type="number" class="form-control" id="recipient-name" name="months" >
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                               <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordpopper'.$i.'" aria-label="Close">SEND</button>
                   </div>
                             </div>
                        
                           </div>
                         </div>
                       </div>
                       <!--Popper ends-->
                    <!--password Popper starts-->  
                    <div class="modal fade" id="passwordpopper'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                       
                               <div class="mb-3">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for '.$name.'</h1>
                                   <label for="recipient-name" class="col-form-label">Enter your passowrd</label>
                                   <input type="number" class="form-control" id="recipient-name" name="months" maxlength="4" title="$ digits only are required!" >
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                               <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#successpopper'.$i.'" >SEND</button>
                   </div>
                             </div>
                          
                           </div>
                         </div>
                       </div>
                       <!-- password Popper ends-->
                         <!--Transaction complete starts-->  
                    <div class="modal fade" id="successpopper'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                               <div class="mb-3 text-center">
                                   <label for="recipient-name" class="col-form-label">Transaction Successful for '.$name.'!</label>
                                 </div>
                   <div style="margin-left:90%">
                              
                               <input type="hidden" name="action" value="addproduct">
                               <input type="hidden" name="product_id" value="'.$product.'">
                                <input type="hidden" name="price" value="'.$price.'">
                               <input type="hidden" name="barcode" value="'.$barcode.'">
                               <button type="submit" class="btn btn-secondary btn-sm" >OK</button>
                   </div>
                             </div>
                             </form>
                           </div>
                         </div>
                       </div>
                       
                       <!-- transaction complete ends-->
';
$i++;
            }

            ?>
               
            </tbody>
        </table>
    </div>
    
    <!--Add product starts-->  
    <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add a product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
                <input type="hidden" name="action" value="addproduct">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Product Name</label>
                <input type="text" class="form-control" id="recipient-name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Price</label>
                <input type="number" class="form-control" id="recipient-name" name="price" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Quantity</label>
                <input type="price" class="form-control" id="recipient-name" name="quantity" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >Scan Barcode</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Add Product ends-->

    <!--Table ends-->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/vanilla-zoom.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>