<?php
include '../control/connection.php';
if($_SERVER["REQUEST_METHOD"]=="POST"  && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='addcategory'){
    $category_name=$_POST['category_name'];
    $sql="insert into category(category_name) values('$category_name')";
    $conn->query($sql);
        header('Location: category.php');
    }
} 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Administrator</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/vanilla-zoom.min.css">
</head>
<body>
<section class="clean-block clean-form dark enroll"  id="supplier">
        <div class="container ">
            <div class="block-heading">
                <h2 class="text-info">Add Category</h2>
            </div>
            <form method="post">
                <div class="mb-3"><label class="form-label" for="email">Enter Category name</label>
                <input type="text" class="form-control" id="recipient-name" name="category_name" required>
                <input type="hidden" class="form-control" id="recipient-name" name="action" value="addcategory" >
                   
                </div><button class="btn btn-primary" type="submit" >Add</button>
            </form>
        </div>
    </section>
</body>
</html>