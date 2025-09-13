<?php 

include"server/connection.php"; 
//use the search section
if (isset($_POST["search"])) {

   //1.determine page no
   if(isset($_GET["page_no"]) && $_GET['page_no'] != "" ) {
    //if user has already entered page then n0 is that they selected
    $page_no = $_GET["page_no"];
  }else{
    //if user just entered the page the default page is 1
    $page_no = 1;
  }

  $category = $_GET["category"];
  $price = $_GET["price"];

   //2.return no of products 
   $stmt = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category=? AND product_price<=?");
   $stmt->bind_param("si", $category,$price);
   $stmt->execute();
   $stmt->bind_result($total_records);
   $stmt->store_result();
   $stmt->fetch();

  //3. products per page
    $total_records_per_page = 8;

    $offset = ($page_no - 1 ) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacent = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page);

      
      //4. get all products
    $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=? LIMIT $offset,$total_records_per_page");
    $stmt2->bind_param("si", $category,$price);
    $stmt2->execute();
    $result = $stmt2->get_result();

  //return all products --> if you have small website e.g 1000
} else {

  //1.determine page no
  if(isset($_GET["page_no"]) && $_GET['page_no'] != "" ) {
    //if user has already entered page then n0 is that they selected
    $page_no = $_GET["page_no"];
  }else{
    //if user just entered the page the default page is 1
    $page_no = 1;
  }

  //2.return no of products 
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();
}

//3. products per page
$total_records_per_page = 8;

$offset = ($page_no - 1 ) * $total_records_per_page;

$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$adjacent = "2";

$total_no_of_pages = ceil($total_records/$total_records_per_page);

//4. get all products
$stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page");
$stmt2->execute();
$result = $stmt2->get_result();

?>


<?php include('layout/header.php') ?>

     
<!--     
      search
     <section id="search" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
          <p>Search Products</p>
          <hr>
        </div>

          <form action="shop.php" method="GET">
            <div class="row mx-auto container">
              <div class="col-lg-12 col-md-12 col-sm-12">

                <p>Category</p>
                  <div class="form-check">
                    <input type="radio" value="dress" class="form-check-input" name="category" id="category_one" <?php if(isset($category) && $category=='dress') { echo 'checked';}?>>
                    <label for="flexRadioDefault1" class="form-check-label" >
                      Latest Suits
                    </label>
                  </div>

                  <div class="form-check">
                    <input type="radio" value="wears" class="form-check-input" name="category" id="category_two" <?php if(isset($category)   && $category=='wears') { echo 'checked';}?>>
                    <label for="flexRadioDefault2" class="form-check-label" >
                      Awesome Suits
                    </label>
                  </div>

                  <div class="form-check">
                    <input type="radio" value="watch" class="form-check-input" name="category" id="category_two" <?php if(isset($category)  && $category=='watch') { echo 'checked';}?>>
                    <label for="flexRadioDefault2" class="form-check-label" >
                      Watches
                    </label>
                  </div>

                  <div class="form-check">
                    <input type="radio" value="shoe" class="form-check-input" name="category" id="category_two" <?php if(isset($category)  && $category=='shoe') { echo 'checked';}?>>
                    <label for="flexRadioDefault2" class="form-check-label" >
                      Shoes
                    </label>
                  </div>
              </div>
            </div>

            <div class="row mx-auto container mt-5">
              <div class="col-lg-12 col-md-12 col-sm-12">

              <p>Price</p>
              <input type="range" name="price" value="<?php if(isset($price)) { echo $price; }else{ echo "100";} ?>" class="form-range w-50" min="1" max="1000" id="customRange">
              <div class="w-50">
                <span style="float: left;">1</span>
                <span style="float: right;">1000</span>
              </div>
              </div>
            </div>

            <div class="form-group my-3 mx-3">
              <input type="submit" class="btn btn-primary" name="search" value="Search">
            </div>
          </form>
     </section> -->

     <!--shop-->
     <section id="featured" class="my-5 pb-5">
        <div class="container mt-5 py-5 ">
            <h3>Our Products</h3>
            <hr class="">
            <p>here you can Check out our  Products</p>
        </div>
        <div  class="row mx-auto container main">

          <?php while($row = $result->fetch_assoc()){ ?>
            <div onclick="window.location.href='single_product.php';" class="pro text-center col-lg-3 col-md-4 col-sm-12">
                <img src="assets/imgs/<?php echo $row['product_image']; ?>" class="img-fluid mb-3" alt="">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price">$<?php echo $row['product_price']; ?></h4>
                <a class="btn buy-btn" href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>">Buy Now</a>
            </div>
            <?php } ?>
        </div>
      </section>

          <div class="row container mx-auto">
            <nav aria-label="page navigation example">
                <ul class="pagination mt-5 mx-auto">
                    <li class="page-item<?php if($page_no<=1) { echo 'disabled';} ?>">
                       <a class="page-link" href="<?php echo ($page_no <= 1) ? '#' : '?page_no=' . ($page_no - 1); ?>">Previous</a>
                    </li>

                    <li class="page-item"><a href="?page_no=1" class="page-link">1</a></li>
                    <li class="page-item"><a href="?page_no=2" class="page-link">2</a></li>
                    
                    <?php if( $page_no >=3 ) {?>
                      <li class="page-item"><a href="#" class="page-link">...</a></li>
                      <li class="page-item"><a href=" <?php echo "?page_no".$page_no ;?>" class="page-link"></a> <?php echo $page_no ;?></li>
                       
                    <?php }?>

                    <li class="page-item<?php if($page_no>= $total_no_of_pages) { echo 'disabled';} ?>">
                      <a class="page-link" href="<?php echo ($page_no >= $total_no_of_pages) ? '#' : '?page_no=' . ($page_no + 1); ?>">Next</a>
                    </li>
                </ul>
            </nav>
          </div>

  <?php include('layout/footer.php') ?>
