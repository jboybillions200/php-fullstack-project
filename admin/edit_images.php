<?php 
  include("../server/connection.php");

  if (isset($_GET["product_id"]) && isset($_GET["product_name"])) { 
    $product_id = $_GET["product_id"];
    $product_name = $_GET["product_name"];
  } else {
    header("Location: product.php");
    exit();
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
          </div>

          <h2>Update Product Images</h2>

          <div class="table-responsive">
            <div class="mx-auto container mt-3">
              <form action="update_images.php" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['error'])): ?>
                  <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>

                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>" />
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" />

                <div class="form-group mt-2">
                  <label>Image 1</label>
                  <input type="file" name="image1" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                  <label>Image 2</label>
                  <input type="file" name="image2" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                  <label>Image 3</label>
                  <input type="file" name="image3" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                  <label>Image 4</label>
                  <input type="file" name="image4" class="form-control" required>
                </div>

                <div class="form-group mt-3">
                  <input type="submit" name="update_images" value="Update" class="btn btn-primary" />
                </div>
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
