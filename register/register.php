<?php
include '../control/connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];


    if($action==='register'){
      $name=$_POST['name'];
      $phone=$_POST['phone'];
      $email=$_POST['email'];
      $role=$_POST['role'];
      $category=$_POST['category'];
      $location=$_POST['location'];
      $password=$_POST['password'];
      $sql="insert into users(name,phone,email,location,role,password,category) values('$name','$phone','$email','$location','$role','$password','$category')";
      if ($conn->query($sql) === TRUE) { 
          $query1 = "SELECT * FROM users where email= '$email' and password='$password'";
          $result1 = mysqli_query($conn, $query1);
          while($row1= $result1->fetch_assoc()) {
            $id=$row1['id'];
            $role=$row1['role'];
            session_start();
            $_SESSION['user']=$id;
            if($role==1){
                header('Location: ../supplier/supplierslogin.php');

            }elseif($role==2){
                header('Location: ../wholesaler/wholesalerslogin.php');
            }
          }
        }
      }
    }
    
    
$query3 = "SELECT * from category";
$result3 = mysqli_query($conn, $query3);
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
<section class="clean-block clean-form dark enroll "id="new">
        <div class="container " >
            <div class="block-heading">
                <h2 class="text-info">New member Register</h2>
            </div>
            <form method="post">
                <input type="hidden" name="action" value="register">
                <div class="mb-3"><label class="form-label" for="name">Full Name</label><input class="form-control item" type="text" id="name" name="name" required></div>
                <div class="mb-3"><label class="form-label" for="password">Email</label><input class="form-control item" type="email" id="password-2" name="email" required></div>
                <div class="mb-3"><label class="form-label" for="email">Phone Number</label><input class="form-control item" type="number" id="email-2" name="phone" required></div>
                <div class="mb-3"><label class="form-label" for="email">Location</label><input class="form-control item" type="text" id="email-2" name="location" placeholder="Region-District-Ward" required></div>
                <div class="mb-3"><label class="form-label" for="email">Enrolled As</label>
                    <select class="form-select" name="role" required>
                            <option value="1">Supplier</option>
                            <option value="2">Wholesaler</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label" for="email">Select sales category</label>
                    <select class="form-select" name="category" required>
                        <?php
                    while($row= $result3->fetch_assoc()) {
                                $category_name=$row['category_name'];
                                $category_id=$row['id'];
                                echo "
                            <option value=\"$category_id\">$category_name</option>
                            ";
                    }
                            ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label" for="email">Password</label><input class="form-control item" type="password" id="email-3" name="password" required></div>
                <button class="btn btn-primary" type="submit">Sign Up</button>
            </form>
        </div>
    </section>
</body>
</html>