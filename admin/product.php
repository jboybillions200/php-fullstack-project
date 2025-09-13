<?php 
 if(isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
 }

?>
<?php 

include "../server/connection.php";

// 1. Determine current page number
if (isset($_GET["page_no"]) && $_GET["page_no"] != "") {
  $page_no = $_GET["page_no"];
} else {
  $page_no = 1;
}

// 2. Count total number of records
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// 3. Set number of records per page
$total_records_per_page = 5;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// 4. Fetch records for current page
$stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$products = $stmt2->get_result();



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

    <main>
      <h2 class="border-bottom mb-3">Products</h2>

      <?php if(isset($_GET['edit_success_message'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['edit_success_message']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['edit_failure_message'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
      <?php } ?>


      <?php if(isset($_GET['deleted_succesfully'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['deleted_succesfully']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['deleted_failure'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['product_created'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['product_created']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['product_failure'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['product_failure']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['images_updated'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['images_updated']; ?></p>
      <?php } ?>
      <?php if(isset($_GET['images_failed'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['images_failed']; ?></p>
      <?php } ?>

      <div class="table-responsive">
  <table class="table table-striped table-sm small">
    <thead>
      <tr>
        <th scope="col">Products Id</th>
        <th scope="col">Products Image</th>
        <th scope="col">Products Name</th>
        <th scope="col">Products Price</th>
        <th scope="col">Products Offer</th>
        <th scope="col">Products Category</th>
        <th scope="col">Products Color</th>
        <th scope="col" class="small">Edit Images</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>  
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $product) { ?>
        <tr>
          <td><?php echo $product['product_id']; ?></td>
          <td><img src="<?php echo "../assets/imgs/". $product['product_image']; ?>" style="width: 70px; height: 70px;"/></td>
          <td><?php echo $product['product_name']; ?></td>
          <td><?php echo "$". $product['product_price']; ?></td>
          <td><?php echo $product['product_special_offer'] . "%"; ?></td>
          <td><?php echo $product['product_category']; ?></td>
          <td><?php echo $product['product_color']; ?></td>
          <td><a href="<?php echo "edit_images.php?product_id=".$product['product_id']."&product_name=".$product['product_name']; ?>" class="btn btn-primary"  style="font-size: 10px;">Edit Images</a></td>
          <td><a href="edit_product.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Edit</a></td>
          <td><a href="delete_product.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-danger">Delete</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

      <div class="order container mx-auto">
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
    </main>

    



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
