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
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// 3. Set number of records per page
$total_records_per_page = 8;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// 4. Fetch records for current page
$stmt2 = $conn->prepare("SELECT * FROM orders LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$orders = $stmt2->get_result();



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
      margin-left: 250px;
      padding: 20px;
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
    <h2>Orders</h2>

    <?php if(isset($_GET['order_updated'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['order_updated']; ?></p>
      <?php } ?>

      <?php if(isset($_GET['order_failed'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['order_failed']; ?></p>
      <?php } ?>

       <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Order Id</th>
              <th scope="col">Order Status</th>
              <th scope="col">User Id</th>
              <th scope="col">Order Date</th>
              <th scope="col">user Phone</th>
              <th scope="col">user Address</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>  
            </tr>
          </thead>
          <tbody>
          <?php foreach($orders as $order) { ?>
              <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['order_status']; ?></td>
                <td><?php echo $order['user_id']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['user_phone']; ?></td>
                <td><?php echo $order['user_address']; ?></td>

              
                <td><a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary">Edit</a></td>
                <td><a href="delete_order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-danger">Delete</a></td>
              </tr>
            <?php } ?>
          </tbody>
          </thead>
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
