<?php
include '../control/connection.php';
$barcode=$_POST['barcode'];
$wholesaler=$_POST['wholesaler'];
$quantity=$_POST['quantity'];

$sql0 = "SELECT * FROM products inner join stock on stock.product=products.id where products.barcode='$barcode' ";
$result0 = $conn->query($sql0);
while($row1 = $result0->fetch_assoc()) {
  $product=$row1['id'];
  $existing_quantity=$row1['quantity'];

  $sql1="update stock set quantity=quantity-$quantity where product=$product";
  $result1 = $conn->query($sql1);
  $sql="insert into sales(wholesaler,product,quantity) values('$wholesaler','$product','$quantity')";
  $result = $conn->query($sql);
  header('Location: sales.php');
}

?>