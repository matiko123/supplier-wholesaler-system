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
                <h2 class="text-info">Administrator's Login</h2>
            </div>
            <form method="post" action="../control/adminlogin.php">
                <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control item" type="email" name="email" id="email-1" required></div>
                <div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" type="password" name="password" id="password-1" required></div>
                <div class="mb-3">
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="checkbox-1"><label class="form-check-label" for="checkbox-1">Remember me</label></div>
                </div><button class="btn btn-primary" type="submit" >Log In</button>
            </form>
        </div>
    </section>
</body>
</html>