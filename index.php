
    <?php include('layout/header.php') ?>
      <!--Home-->
      <section id="home" class="">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices</span> This Season</h1>
            <p>Eshop Offers The Best Products For The Most Affordable Prices</p>
            <button>Shop Now</button>
        </div>
      </section>


      <!--brands-->
      <section id="brand" class="container my-lg-5">
        <div class="row ">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.jpg " alt="">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.jpg " alt="">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.jpg " alt="">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.jpg " alt="">
        </div>
      </section>

      <!--new-->
      <section id="new" class="w-100 my-lg-5">
        <div class="row p-0 m-0">
            <!--one-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="assets/imgs/shoe.jpg" alt="" class="img-fluid">
                <div class="details">
                    <h2>Extremely Awesome Shoes</h2>
                    <button class="text-uppercase">Shop Now</button>
                </div>
            </div>
            <!--two-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="assets/imgs/bag.jpg" alt="" class="img-fluid">
                <div class="details">
                    <h2> Awesome bags</h2>
                    <button class="text-uppercase">Shop Now</button>
                </div>
            </div>
            <!--three-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img src="assets/imgs/watch.jpg" alt="" class="img-fluid">
                <div class="details">
                    <h2>50% off Watches</h2>
                    <button class="text-uppercase">Shop Now</button>
                </div>
            </div>
        </div>
      </section>


      <!--featured-->
      <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5 ">
            <h3>Our Featured</h3>
            <hr class="mx-auto">
            <p>here you can Check out our Featured Products</p>
        </div>
        <div class="row mx-auto container-fluid main">

        <?php
          include'server/get_suit.php';
        ?>

        <?php
          while($row = $result->fetch_assoc()){
        ?>
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/<?php echo $row['product_image'];?>" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name'];?></h5>
                <h4 class="p-price">$ <?php echo $row['product_price'];?></h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?></a>"><button class="buy-btn">Buy Now</button></a>
            </div>
            <?php } ?>
        </div>
      </section>

      <!--banner-->
      <section id="banner">
        <div class="container">
          <h4 class="text-white">MID SEASON'S SALE</h4>
          <h1>Autum Collection <br>Up to Off</h1>
          <button class="text-uppercase">Shop Now</button>
        </div>
      </section>

      <!--clothes-->
      <section id="clothes" class="my-5">
        <div class="container text-center mt-5 py-5 ">
            <h3>Dresses $ Suits</h3>
            <hr class="mx-auto">
            <p>here you can Check out our Amazing Clothes</p>
        </div>
        
        <div class="row mx-auto container-fluid main">
        <?php 
          include 'server/get_wears.php';
        ?>

        <?php 
          while($row = $result->fetch_assoc()){
        ?>
        
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
            <img src="assets/imgs/<?php echo $row['product_image'];?>" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name'];?></h5>
                <h4 class="p-price">$ <?php echo $row['product_price'];?></h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?></a>"><button class="buy-btn">Buy Now</button></a>
                <!-- <button class="buy-btn">Buy Now</button> -->
            </div>
          <?php } ?>
        </div>
      </section>

      <!--watches-->
      <section id="watches" class="my-5">
          <div class="container text-center mt-5 py-5 ">
              <h3>Best Watches</h3>
              <hr class="mx-auto">
              <p>  Checkout our unique Watches</p>
          </div>
          <div class="row mx-auto container-fluid main">

            <?php 
              include 'server/get_watches.php';
            ?>

            <?php 
              while($row = $result->fetch_assoc()){
            ?>

              <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                  <img src="assets/imgs/<?php echo $row['product_image']; ?>" class="img-fluid mb-3" alt="">
                  <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </div>
                  <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                  <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                  <!-- <button class="buy-btn">Buy Now</button> -->
                  <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?></a>"><button class="buy-btn">Buy Now</button></a>
                </div>
              
             <?php } ?>
          </div>
      </section>

      <!--shoes-->
      <section id="shoes" class="my-5">
        <div class="container text-center mt-5 py-5 ">
            <h3>Shoes</h3>
            <hr class="mx-auto">
            <p>here you can Check out our Amazing shoes</p>
        </div>
        <div class="row mx-auto container-fluid ">

        <?php
        include'server/get_shoes.php';
        ?>
        <?php
         while($row = $result->fetch_assoc()){
        ?>
            <div class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/<?php echo $row['product_image']; ?>" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?></a>"><button class="buy-btn">Buy Now</button></a>
                <!-- <button class="buy-btn">Buy Now</button> -->
            </div>
            <?php } ?>
         </div>
      </section>

      <?php include('layout/footer.php') ?>


    