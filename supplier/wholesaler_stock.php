<?php
include '../control/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



session_start();
$supplier_id=$_SESSION['supplier'];
$wholesaler_id=$_GET['wholesaler'];
$query1 = "SELECT stock.*,products.name as product_name FROM stock inner join products on products.id=stock.product where wholesaler=$wholesaler_id";
$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT * from users where id  =$supplier_id";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $supplier_name=$row1['name'];
    $supplier_email=$row1['email'];
  }

$query3 = "SELECT * from users where id  =$wholesaler_id";
$result3 = mysqli_query($conn, $query3);
while($row1 = $result3->fetch_assoc()) {
    $wholesaler_email=$row1['email'];
    $wholesaler_name=$row1['name'];
  }

 //required files
require '../mailer/src/Exception.php';
require '../mailer/src/PHPMailer.php';
require '../mailer/src/SMTP.php';
 if($_SERVER["REQUEST_METHOD"]=="POST"){
    $title=$supplier_name;
    $product_name=$_POST['product_name'];
    $message="Dear $wholesaler_name , it seems like you are running out of $product_name stock. Please contact us via $supplier_email if you want anything from our store... Thank you";
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'christianstephen025@gmail.com';   //SMTP write your email
    $mail->Password   = 'oktbibdggmoktqmi';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom("christianstephen025@gmail.com", $title); // Sender Email and name
    $mail->addAddress("$wholesaler_email");     //Add a recipient email  
    $mail->addReplyTo($supplier_email, "E-Distribution system Customer"); // reply to sender email

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = "EDS notification";   // email subject headings
    $mail->Body    = $message; //email message
    $mail->send();
  echo "<script>alert('An email was sent')</script>";
    echo "<script>location.href='wholesaler.php'</script>";;
    exit();
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
                    <li class="nav-item item"><a class="nav-link active" href="wholesaler.php">Wholesalers</a></li>
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
                    <th>Product</th>
                    <th>Status</th>
                    <th>Send Inquiry</th>
                </tr>
            </thead>
            <tbody>
                <?php 
            while($row1= $result1->fetch_assoc()) {
               $product=$row1['product_name'];
               $quantity=$row1['quantity'];
               if($quantity<20){
                $quantity="Almost Out of stock..";
                $status='class="text-danger"';
                $button='btn btn-outline-danger';
               }else{
                $quantity="stock Available..";
                $status='class="text-dark"';
                $button='btn btn-outline-primary';
               }
               echo '
               <tr>
                    <td '.$status.' >'.$product.'</td>
                    <td '.$status.'>'.$quantity.'</td>
                    <form method="post">
                    <input type="hidden" name="product_name" value="'.$product.'">
                     <td><button class="'.$button.'" type="submit">
                     Send 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-check" viewBox="0 0 16 16">
  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178 1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494-1.895 4.738a.5.5 0 1 0 .928.372zm-2.54 1.183L5.93 9.363 1.591 6.602z"/>
  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"/>
</svg></button></td>
                </tr>
                </form>
               ';
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