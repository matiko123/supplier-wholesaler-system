<?php
include 'control/connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];


    if($action==='register'){
      $name=$_POST['name'];
      $phone=$_POST['phone'];
      $email=$_POST['email'];
      $role=$_POST['role'];
      $password=$_POST['password'];
      $sql="insert into users(name,phone,email,role,password) values('$name','$phone','$email','$role','$password')";
      if ($conn->query($sql) === TRUE) { 
          //header('Location: ./');
          //exit();
          $query1 = "SELECT * FROM users where email= '$email' and password='$password'";
          $result1 = mysqli_query($conn, $query1);
          while($row1= $result1->fetch_assoc()) {
            $id=$row1['id'];
            $role=$row1['role'];
            session_start();
            $_SESSION['user']=$id;
            if($role==1){
                header('Location: supplier/');
            }elseif($role==2){
                header('Location: wholesaler/');
            }
          }
        }
      }elseif($action==='wholesaler'){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $sql="select * from users where email= '$email' and password='$password'";
        if ($conn->query($sql) === TRUE) {     
                 echo "<script>alert('$email and $password')</script>";    
                 // header('Location: wholesaler/');
              }
        }elseif($action==='supplier'){
            $email=$_POST['email'];
            $password=$_POST['password'];
            $sql="select * from users where email= '$email' and password='$password'";
            if ($conn->query($sql) === TRUE) {      
                echo "<script>alert('$email and $password')</script>";  
                // header('Location: supplier/');
                  }
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
    <title>Home - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/vanilla-zoom.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="page landing-page" id="backbone">
        <section class="clean-block clean-hero" style="background-image:url(&quot;assets/img/tech/image4.jpg&quot;);color:rgba(43, 55, 63, 0.85);min-height: 15cm!important;">
            <div class="text" style="margin-top: -5cm;">
                <h2>Are you a supplier, wholesaler or new here?</h2>
                <button class="btn btn-outline-light btn-lg" type="button" onclick="location.href='supplier/supplierslogin.php'">Supplier</button>
                <button class="btn btn-outline-light btn-lg" type="button" onclick="location.href='wholesaler/wholesalerslogin.php'">Wholesaler</button>
                <button class="btn btn-outline-light btn-lg" type="button" onclick="location.href='register/register.php'">Register Now</button>
            </div>
        </section>
    </main>

    <section class="clean-block clean-form dark enroll "id="new">
        <div class="container "  >
            <div class="block-heading">
                <h2 class="text-info">New member Register</h2>
            </div>
            <form method="post">
                <input type="hidden" name="action" value="register">
                <div class="mb-3"><label class="form-label" for="name">Full Name</label><input class="form-control item" type="text" id="name" name="name" required></div>
                <div class="mb-3"><label class="form-label" for="password">Email</label><input class="form-control item" type="email" id="password-2" name="email" required></div>
                <div class="mb-3"><label class="form-label" for="email">Phone Number</label><input class="form-control item" type="number" id="email-2" name="phone" required></div>
                <div class="mb-3"><label class="form-label" for="email">Enrolled As</label>
                    <select class="form-select" name="role" required>
                        <optgroup label="Please Select One">
                            <option value="1">Supplier</option>
                            <option value="2">Wholesaler</option>
                        </optgroup>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label" for="email">Password</label><input class="form-control item" type="password" id="email-3" name="password" required></div>
                
                <button class="btn btn-primary" type="submit">Sign Up</button>
            </form>
        </div>
    </section>
    <footer class="page-footer dark">
      
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2024 Copyright All Right Reserved by 2024 students.</p>
        </div>
    </footer>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/vanilla-zoom.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>