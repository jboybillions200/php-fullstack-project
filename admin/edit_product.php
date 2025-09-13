<?php 
  
  include("../server/connection.php");

    if(isset($_GET['product_id'])){

        
        $product_id = $_GET['product_id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE  product_id = ?");
        $stmt->bind_param("i", $product_id );
        $stmt->execute();
        $products = $stmt->get_result();
    }elseif(isset($_POST['edit_btn'])){

        $product_id = $_POST['product_id'] ;
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $offer = $_POST['offer'];
        $color = $_POST['color'];
        $category = $_POST['category'];

        $stmt = $conn->prepare('UPDATE products SET product_name=?, product_description=?, product_price=?,
                                      product_special_offer=?, product_color=?, product_category=? WHERE product_id=?');
        $stmt->bind_param('ssssssi', $title,$description, $price, $offer, $color, $category,$product_id );
      
        if( $stmt ->execute()){
            header('Location: product.php?edit_success_message=Product Has Been Updated Successfully');
        }else{
            header('Location: product.php?edit_failure_message=Error Occured Try Again');
        }

    }else{
        header('Location: product.php');
        exit;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  
 <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: order;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background: #2c3e50;
      color: white;
      transition: transform 0.3s ease-in-out;
    }

    .sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 100vh;
  background: #2c3e50;
  color: white;
  overflow-y: auto;
  z-index: 1001;
  padding-top: 60px; /* Adjust for fixed header */
}

.main {
  margin-left: 250px;
  padding: 20px;
}

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar h2 {
      padding: 1rem;
      border-bottom: 1px solid #34495e;
    }

    .sidebar a {
      display: block;
      padding: 1rem;
      color: white;
      text-decoration: none;
      border-bottom: 1px solid #34495e;
    }

    .sidebar a:hover {
      background: #34495e;
    }

    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    header {
      background: #2980b9;
      color: white;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .toggle-btn {
      font-size: 1.5rem;
      cursor: pointer;
      display: none;
    }

    footer {
      background: #ecf0f1;
      padding: 1rem;
      text-align: center;
      margin-top: auto;
    }

    main {
      padding: 2rem;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        z-index: 1000;
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .toggle-btn {
        display: block;
      }

      .main {
        width: 100%;
      }

      .overlay {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 999;
      }

      .overlay.hidden {
        display: none;
      }
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>

  <div class="main">
    <?php include 'navbar.php'; ?>
<div class="container-fluid">
    <div class="row" style="min-height: 1000px;">
        
<main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

            </div>
        </div>
    </div>

    <h2>Edit Product</h2>
    <div class="table-responsive">
        <div class="mx-auto container mt-5">
            <form action="edit_product.php" id="edit_form" method="post" >
                <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                <div class="form-group mt-2">
                    <?php foreach($products as $product) { ?>
                       <input type="hidden" name="product_id" value="<?php echo $product['product_id']?>" /> 

                    <label for="">Title</label>
                    <input type="text" name="title" id="product_name" value="<?php echo $product['product_name']?>" class="form-control"  placeholder="Title" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Description</label>
                    <input type="text" name="description" id="product_description" value="<?php echo $product['product_description']?>"  class="form-control"  placeholder="Description" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Price</label>
                    <input type="text" name="price" id="product_price" class="form-control" value="<?php echo $product['product_price']?>"  placeholder="Price" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Category</label>
                    <select name="category" id="" class="form-select" required>
                        <option value="">Select</option>
                        <option value="bag">Bags</option>
                        <option value="shoe">Shoes</option>
                        <option value="watch">Watches</option>
                        <option value="wears">Clothes</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">Color</label>
                    <input type="text" name="color" id="product_color" class="form-control" value="<?php echo $product['product_color']?>"  placeholder="Color" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Special Offer/ Sale</label>
                    <input type="number" name="offer" id="product_offer" class="form-control" value="<?php echo $product['product_special_offer']?>"  placeholder="Sales %" required>
                </div>

                <div class="form-group mt-2">
                    <input type="submit" name="edit_btn" value="Edit Product" class="btn btn-primary" id="edit_product_btn">
                </div>

                <?php } ?>

            </form>
        </div>
    </div>
     

     </main>
    </div>
</div>

    <?php include 'footer.php'; ?>
  </div>

  <div class="overlay hidden" id="overlay" onclick="toggleSidebar()"></div>

  <script>
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    function toggleSidebar() {
      sidebar.classList.toggle("show");
      overlay.classList.toggle("hidden");
    }

    
  </script>
</body>
</html>

