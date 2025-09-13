<?php 

include("../server/connection.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result();

} else if (isset($_POST["edit_order"])) { // Fix typo: $_POSTT to $_POST

    $order_status = $_POST["order_status"];
    $order_id = $_POST["order_id"];

    // Removed extra comma in the SQL statement
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();

    header("Location: index.php?order_updated=Order Has Been Updated Successfully");
    exit;

} else {
    header("Location: index.php?order_failed=Error Occurred Try Again");
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

    <h2>Edit Orders</h2>
    <div class="table-responsive">
        <div class="mx-auto container mt-5">
            <form action="edit_order.php" id="edit_form" method="post" >
                <?php foreach($order as $r) { ?>
                <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                <div class="form-group my-3">
                  <label for="">Order Id</label>
                  <p class="my-4"><?php echo $r['order_id'] ?></p>
                </div>

                <div class="form-group my-3">
                  <label for="">Order Price</label>
                  <p class="my-4"><?php echo $r['order_cost'] ?></p>
                </div>


                <input type="hidden" name="order_id" value="<?php echo $r['order_id'] ;?>">
                <div class="form-group my-3">
                  <label for="">Order Status</label>
                  <select name="order_status" class="form-select" required id="">
                    <option value="not paid"<?php if($r['order_status'] == 'not paid') { echo "selected"; } ?>>Not Paid</option>
                    <option value="paid"<?php if($r['order_status'] == 'paid') { echo "selected"; } ?>>Paid</option>
                    <option value="shipped"<?php if($r['order_status'] == 'shipped') { echo "selected"; } ?>>Shipped</option>
                    <option value="delivered"<?php if($r['order_status'] == 'delivered') { echo "selected"; } ?>>Delivered</option>
                  </select >
                </div>

                <div class="form-group my-3">
                  <label for="">Order Date</label>
                  <p class="my-4"><?php echo $r['order_date'] ?></p>
                </div>

                <div class="form-group mt-2">
                    <input type="submit" name="edit_order" value="Edit Order" class="btn btn-primary" id="edit_product_btn">
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

