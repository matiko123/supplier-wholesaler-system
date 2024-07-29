<?php
include '../control/connection.php';
session_start();
$admin_id=$_SESSION['admin'];
$query = "SELECT * from admin where id  =$admin_id";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * from category";
$result1 = mysqli_query($conn, $query1);

while($row= $result->fetch_assoc()) {
    $admin_email=$row['email'];
} 
if($_SERVER["REQUEST_METHOD"]=="POST"  && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='addcategory'){
    $category_name=$_POST['category_name'];
    $sql="insert into category(category_name) values('$category_name')";
    $conn->query($sql);
        header('Location: '.$_SERVER['PHP_SELF']);
    }elseif($action==='deletecategory'){
        $category_id=$_POST['category_id'];
        $sql="delete from category where id=$category_id";
        $conn->query($sql);
            header('Location: '.$_SERVER['PHP_SELF']);
        }elseif($action==='editcategory'){
            $category_id=$_POST['category_id'];
            $category_name=$_POST['category_name'];
            $sql="update category set category_name='$category_name'  where id=$category_id";
            $conn->query($sql);
                header('Location: '.$_SERVER['PHP_SELF']);
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
                    <li class="nav-item item"><a class="nav-link active" href="#">Categories</a></li>
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
<div class="container" style="margin-top: 3cm;margin-bottom: -3cm">

<label class=" btn btn-outline-primary btn-sm" style="margin-left: 80%;margin-top: 1cm;" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</label>
</div><br>
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
          
                <?php
                $i=1;
            while($row= $result1->fetch_assoc()) {
             $name=$row['category_name'];
             $id=$row['id'];
  echo"
   <tr>
                     <td>$i</td>
                    <td>$name </td>
                    <td><button class=\"btn btn-success\" data-bs-toggle=\"modal\" data-bs-target=\"#editCategory$i\">Edit</button></td>
                    <form method=\"post\">
                    <input type=\"hidden\" class=\"form-control\" name=\"action\" value=\"deletecategory\" >
                    <input type=\"hidden\" class=\"form-control\" name=\"category_id\" value=\"$id\" >
                    <td><button class=\"btn btn-danger\" type=\"submit\">Delete</button></td>
                    </form>
   </tr>
         ";  
         echo '
          <!--edit category starts-->  
 <div class="modal fade" id="editCategory'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color:white">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit  category </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Category Name</label>
                <input type="text" class="form-control" id="recipient-name" name="category_name" required>
                <input type="hidden" class="form-control" id="recipient-name" name="action" value="editcategory" >
                <input type="hidden" class="form-control"  name="category_id" value="'.$id.'" >
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" >Edit</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Add category ends-->
         ';
        $i++;
     }
                    ?>
            </tbody>

        </table>
    </div>
 <!--Add category starts-->  
 <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add a  category </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Category Name</label>
                <input type="text" class="form-control" id="recipient-name" name="category_name" required>
                <input type="hidden" class="form-control" id="recipient-name" name="action" value="addcategory" >
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >Add</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Add category ends-->
    <!--Table ends-->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/vanilla-zoom.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>