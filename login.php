<?php 
session_start();
include("server/connection.php");

if (isset($_SESSION['logged_in'])) {
   header('Location: account.php');
   exit;
}

if (isset($_POST['login_btn'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password']; // Raw password

  // Step 1: Get the hashed password from DB for the email
  $stmt = $conn->prepare('SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? LIMIT 1');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->store_result();

  // If user with this email exists
  if ($stmt->num_rows == 1) {
    $stmt->bind_result($user_id, $user_name, $user_email, $hashed_password);
    $stmt->fetch();

    // Step 2: Verify the password
    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['logged_in'] = true;

      header('Location: account.php?login_success=Logged in successfully');
      exit;
    } else {
      // Password is incorrect
      header('Location: login.php?error=Invalid email or password');
      exit;
    }

  } else {
    // No user found
    header('Location: login.php?error=Invalid email or password');
    exit;
  }
}
?>


<?php include('layout/header.php') ?>

    
    <!--Login Page-->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="login.php" method="post" id="login-form">
            <p style="color: red;" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error'] ;}?></p>
            <div class="form-group">
                    <label for="" class="email">Email</label>
                    <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required> 
                </div>
                <div class="form-group">
                    <label for="" class="password">Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required> 
                </div>
                <div class="form-group">
                    <input type="submit" class="login-btn py-1 rounded-2" name="login_btn" id="login-btn" value="login"> 
                </div>
                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">Don't Have Account? Register</a>
                </div>
            </form>
        </div>
    </section>

    <?php include('layout/footer.php') ?>
