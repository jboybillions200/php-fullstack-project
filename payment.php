<?php 

session_start();

if(isset($_POST['order_pay_btn'])){
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}
?>

<?php include('layout/header.php') ?>
      <!--payment Page-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">

            
          <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
                <?php $amount = strval($_POST['order_total_price']); ?>
                <?php $order_id = $_POST['order_id']; ?>
                <p>Total Payment: $<?php echo $_POST['order_total_price'] ;?></p>
                <!-- <input type="submit" class="btn btn-primary" value="Pay Now" /> -->
                <div class="d-flex justify-content-center align-content-center align-items-center mt-3">
                    <div id="paypal-button-container"></div>
                    <div id="result-message" class="mt-3 text-success font-weight-bold"></div>
                </div>
           
            <?php } 
            //user coming from cart 
            else if(isset($_SESSION['total']) && $_SESSION['total'] != 0 ) { ?>
                <?php $amount = strval($_SESSION['total']); ?>
                <?php $order_id = $_SESSION['order_id']; ?>
                <p>Total Payment: $<?php echo $_SESSION['total'] ;?></p>
                <!-- <input type="submit" class="btn btn-primary" value="Pay Now" /> -->
                <div class="d-flex justify-content-center align-content-center align-items-center mt-3">
                    <div id="paypal-button-container"></div>
                    <div id="result-message" class="mt-3 text-success font-weight-bold"></div>
                </div>
            <?php } else { ?>  
                <p>You dont have an order</p>
            <?php } ?>
        </div>
       
    </section>

        <script>
              const dynamicAmount = <?php echo json_encode($amount); ?>;
              const orderId = <?php echo json_encode($order_id); ?>;
        </script>


         <script
            src="https://www.paypal.com/sdk/js?client-id=AUUGMOhBRob5uFLIdZPHYdaBClEicFg_E40VDjq8oe2boGjfsqO7DHFtaNQJIpm0JJsdjwjybsZZmVS7&buyer-country=US&currency=USD&components=buttons&enable-funding=card&disable-funding=venmo,paylater"
            data-sdk-integration-source="developer-studio"
        ></script>

       

        <script src="app.js"></script>
       
       
    <?php include('layout/footer.php')?>
