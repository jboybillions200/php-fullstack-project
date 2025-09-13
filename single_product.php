  <?php 
  
  include("server/connection.php");

  if(isset($_GET['product_id'])) {

    $product_id =  $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products where product_id = ?");
    $stmt->bind_param("i", $product_id );
    $stmt ->execute();

    $product = $stmt->get_result();


    //no product id was given
  }else {
    header('Location: index.php');
  }
  ?>

<?php include('layout/header.php') ?>

       
    <!--single product-->
    <section class="container single_product my-5 pt-5">
        <div class="row mt-5">

        <?php while($row = $product -> fetch_assoc()){ ?>

             <div class="col-lg-5 col-md-6 col-sm-12">
            <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" class="img-fluid w-100 pb-1" id="mainImg">
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" width="100%" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image2']; ?>" alt="" width="100%" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image3']; ?>" alt="" width="100%" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image4']; ?>" alt="" width="100%" class="small-img">
                </div>
            </div>
           </div>

           <div class="col-lg-6 col-md-12 col-sm-12">
                <h6>Best/suits</h6>
                <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                <h2>$<?php echo $row['product_price']; ?></h2>
                <form action="cart.php" method="POST">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                  <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>
                  <input type="number" name="product_quantity"  value="1">
                <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
              </form>
                 
                <h4 class="mt-4 mb-4">Product Details</h4>
                <span>
                  <?php echo $row['product_description']; ?>
                </span>
           </div>

          
       <?php } ?>

        </div>
    </section>

    <!--related products-->
    <section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5 ">
            <h3>Related products</h3>
            <hr class="mx-auto">
        </div>
        <div class="row mx-auto container-fluid main">
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/watch.jpg" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shoes</h5>
                <h4 class="p-price">$199.8</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/brand3.jpg" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shoes</h5>
                <h4 class="p-price">$199.8</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/brand4.jpg" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shoes</h5>
                <h4 class="p-price">$199.8</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/bag.jpg" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shoes</h5>
                <h4 class="p-price">$199.8</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
        </div>
      </section>

    <script>
       var mainImg =  document.getElementById("mainImg");

       var smallImg = document.getElementsByClassName("small-img");

        for (let i = 0; i < smallImg.length; i++) {
          smallImg[i].onclick = function(){
            mainImg.src = smallImg[i].src;
          }
        }
    </script>

<?php include('layout/footer.php') ?>



















































