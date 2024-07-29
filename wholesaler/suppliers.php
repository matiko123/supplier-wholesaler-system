<?php
include '../control/connection.php';
session_start();
$wholesaler_id=$_SESSION['wholesaler'];
$category=$_GET['category'];
$query1 = "SELECT * FROM users where role=1 and category=$category";
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
    <title>Supplier-Home</title>
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

                                $sql="select count(*) as suppliers  from users where category=$category_id and role=1";
                                $sqlresult=mysqli_query($conn, $sql);
                                while($row1 = $sqlresult->fetch_assoc()) {
                                  $suppliers= $row1['suppliers'];
                                }
                                echo "
                                    <li><a class=\"dropdown-item\" href=\"suppliers.php?category=$category_id\">$category_name($suppliers)</a></li>
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


        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr> <th>#</th>
                    <th>Supplier Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>View Stock</th>
                    <th>View Bio</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i=1;
            while($row1= $result1->fetch_assoc()) {
               $supplier_id=$row1['id'];
               $name=$row1['name'];
               $phone=$row1['phone'];
               $email=$row1['email'];
               $bio=$row1['bio'];
                    echo "
                 <tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td><button class=\"btn btn-outline-success\" onclick=\"location.href='suppliers_stock.php?supplier=$supplier_id'\">view</button></td>
                     <td><button class=\"btn btn-outline-secondary\"  data-bs-toggle=\"modal\" data-bs-target=\"#bio$i\">view</button></td>
                </tr>
                    ";
                    echo '
                      <!--bio starts-->  
 <div class="modal fade" id="bio'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color:white">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Supplier\'s Bio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                <input type="hidden" name="action" value="editprofile">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Name : '.$name.'</label>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Phone : '.$phone.' </label>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Email : '.$email.'</label>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Descriptions : '.$bio.'</label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">ok</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Bio ends-->
                    ';
                    $i++;
                }
              
              ?>
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