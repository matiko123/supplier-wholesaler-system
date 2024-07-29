<?php
// Include the connection file
require_once 'connection.php';

$email = $_POST['email'];;
$passwd = $_POST['password'];

// Retrieve image path from the database
$sql = "SELECT * FROM admin where email='$email' and password='$passwd'";
$result = $conn->query($sql);
while($row1 = $result->fetch_assoc()) {
  $id=$row1['id'];
}
if ($result->num_rows > 0) {
  session_start();
  $_SESSION['admin']=$id; 

    header('Location: ../admin/dashboard.php');
   }
   else{
    header('Location: ../admin/?status=login_fail');
   }
?>