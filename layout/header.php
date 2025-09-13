<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
   <!--Navbar-->
   <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top py-3 shadow-sm">
      <div class="container-fluid mx-auto mx-lg-2 d-flex justify-content-between align-items-center">
        <!-- Left: Logo -->
        <img src="assets/imgs/logo.jpg.png" alt="navbar image" width="50px" height="40px" class="rounded-pill logo">
        <h2 class="brand">Awesome</h2>
        <!-- Right: Nav Links & Icons -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav d-flex align-items-center gap-3">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <!-- Icons -->
            <li class="nav-item d-flex gap-3">
            <a href="cart.php">
              <img src="assets/icons/cart-shopping-solid.svg" class="cart-icon" alt="Cart Icon" width="24" height="24">
              <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0 ) { ?>
                <span class="cart-quantity"><?php echo $_SESSION['quantity']; ?></span>
              <?php } ?>
            </a>
              <a href="account.php"><i class="fa-solid fa-user  cart-icon"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>