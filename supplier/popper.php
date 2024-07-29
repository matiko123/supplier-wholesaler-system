
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
        <div class="container"><a class="navbar-brand logo" href="#"><?php echo $supplier_name ?></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item item"><a class="nav-link " href="index.php">Sales</a></li>
                    <li class="nav-item item"><a class="nav-link" href="wholesaler.php">Wholesalers</a></li>
                    <li class="nav-item item"><a class="nav-link" href="stock.php">My stock</a></li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">my Profile</a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;update Profile</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="../index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                            </div>
                    </li>
                    <li class="nav-item item"><a class="nav-link active" href="#">Subscription</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Table starts-->
<div class="container">
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="margin-top: 3cm!important">
    <label class="fw-bold shadow-lg">You have <?php echo $subscription ?> days remaining for subscription to expire !</label><br><br>
            <div class="container" >
        <table class="table my-0 table-hover container shadow-lg" id="dataTable" >
            <thead>
                <tr>
                    <th >S/NO</th>
                    <th>Plan</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
          
               <tr>
                    <th>$i</th>
                    <th>$month</th>
                    <th>".number_format($price)."</th>
                    <th><button class='btn btn-outline-success' data-bs-toggle="modal" data-bs-target="#popper">Select</th>
               </tr> 
                    ";
                    echo '
                    
                    <!--Popper starts-->  
                    <div class="modal fade" id="popper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                               <form >
                               <div class="mb-3">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for Subscription</h1>
                                   <label for="recipient-name" class="col-form-label">Enter your phone number</label>
                                   <input type="number" class="form-control" id="recipient-name" name="months" required>
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                               <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordpopper'.$plan_id.'" aria-label="Close">SEND</button>
                   </div>
                             </div>
                             </form>
                           </div>
                         </div>
                       </div>
                       <!--Popper ends-->
                    <!--password Popper starts-->  
                    <div class="modal fade" id="passwordpopper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                               <form >
                               <div class="mb-3">
                               <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Payment for Subscription</h1>
                                   <label for="recipient-name" class="col-form-label">Enter your passowrd</label>
                                   <input type="number" class="form-control" id="recipient-name" name="months" maxlength="4" title="$ digits only are required!" required>
                                 </div>
                   <div style="margin-left:60%">
                               <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                               <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#successpopper'.$plan_id.'" >SEND</button>
                   </div>
                             </div>
                             </form>
                           </div>
                         </div>
                       </div>
                       <!-- password Popper ends-->
                         <!--Transaction complete starts-->  
                    <div class="modal fade" id="successpopper'.$plan_id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                         <div class="modal-dialog modal-dialog-centered" >
                           <div class="modal-content bg-dark text-white ">
                             <div class="modal-body">
                               <div class="mb-3 text-center">
                                   <label for="recipient-name" class="col-form-label">Transaction completed Successful! </label>
                                 </div>
                   <div style="margin-left:90%">
                               <form method="post">
                               <input type="hidden" name="plan_id" value="'.$plan_id.'">
                               <input type="hidden" name="subscription" value="'.$subscribing.'">
                                <input type="hidden" name="action" value="subscription">
                               <button type="submit" class="btn btn-secondary btn-sm" >OK</button>
                   </div>
                             </div>
                             </form>
                           </div>
                         </div>
                       </div>
                       <!-- transaction complete ends-->


            </tbody>
        </table>

    </div>
</div>

 <!--Profile starts-->  
     <div class="modal fade" id="editprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit profile Info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post">
                <input type="hidden" name="action" value="editprofile">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Name :</label>
                <input type="text" class="form-control" id="recipient-name" name="name" value="<?php echo $supplier_name ?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Phone : </label>
                <input type="number" class="form-control" id="recipient-name" name="phone" value="<?php echo $phone ?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Email :</label>
                <input type="email" class="form-control" id="recipient-name" name="email" value="<?php echo $email?>">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">bio</label>
                <textarea type="text" class="form-control" id="recipient-name" name="bio" required placeholder="Your self in business career,Your product details,"><?php echo $bio?></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" >submit</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--Profile ends-->
    <!--Table ends-->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../assets/js/vanilla-zoom.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>