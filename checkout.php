<?php 
session_start();

if(!empty($_SESSION["cart"])) {
//let user in


  //send user back to homepage
} else {
  header('Location: index.php');
}
?>


<?php include('layout/header.php') ?>

    
      <!--checkout Page-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="server/place_order.php" id="checkout-form" method="post" >
                <p class="text-center" style="color: red;">
                    <?php if(isset($_GET['message'])){ echo $_GET['message']; } ?>
                    <?php if(isset($_GET['message'])) { ?>
                      <a href="login.php" class="btn btn-primary">Login</a>  
                    <?php }?>
                </p>
                <div class="form-group checkout-small-element">
                    <label for="" class="email">Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required> 
                </div>
                <div class="form-group checkout-small-element">
                    <label for="" class="">Email</label>
                    <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required> 
                </div>
                <div class="form-group checkout-small-element">
                    <label for="" class="">Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="phone" required> 
                </div>
                <div class="form-group checkout-small-element">
                    <label for="" class="">City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required> 
                </div>
                <div class="form-group checkout-large-element">
                    <label for="" class="">Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="address" required> 
                </div>
                <div class="form-group checkout-btn-container">
                    <p>Total Amount: $<?php echo $_SESSION['total']; ?></p>
                    <input type="submit" class="btn py-1 rounded-2" id="checkout-btn" name="place_order" value="Place Order"> 
                </div>
            </form>
        </div>
    </section>

    <?php include('layout/footer.php') ?>
