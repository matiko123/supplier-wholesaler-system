<?php
// Include the connection file
require_once 'connection.php';

$email = $_POST['email'];;
$passwd = $_POST['password'];

// Retrieve image path from the database
$sql = "SELECT * FROM users where email='$email' and password='$passwd' and role=2";
$result = $conn->query($sql);
while($row1 = $result->fetch_assoc()) {
  $id=$row1['id'];
}
if ($result->num_rows > 0) {
  session_start();
  $_SESSION['wholesaler']=$id; 

    header('Location: ../wholesaler/');
   }
   else{
    header('Location: ../?status=login_fail');
   }
?>