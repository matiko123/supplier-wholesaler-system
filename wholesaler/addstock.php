<?php
session_start();
$wholesaler_id=$_SESSION['wholesaler'];
include '../control/connection.php';

      $quantity=$_POST['quantity'];
      $price=$_POST['price'];
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
           // echo "stock is available in store ";
            header('Location: history.php');
        }else{
            $sql="insert into stock (wholesaler,product,quantity,price,barcode) values ('$wholesaler_id','$product_id','$quantity','$price','$barcode')";
            $sql = mysqli_query($conn, $sql);
            $sql1="insert into history (product,quantity,user) values ('$product_id','$quantity','$wholesaler_id')";
            $sql1 = mysqli_query($conn, $sql1);
            $sql2="update products set quantity=quantity-$quantity where id=$product_id ";
            $sql2 = mysqli_query($conn, $sql2);
           // echo "new stock was created seller $wholesaler_id and product= $product_id and quantity = $quantity and price=$price and barcode= $barcode";
           header('Location: history.php');
        }
      
?>