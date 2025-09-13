<?php 
session_start();
include "server/connection.php";

// If user is already logged in, redirect to account
if (isset($_SESSION['logged_in'])) {
  header('Location: account.php');
  exit;
}

if (isset($_POST['register'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // If passwords don't match
  if ($password !== $confirmPassword) {
    header('Location: register.php?error=Passwords do not match');
    exit;
  }

  // If password length is less than 8
  if (strlen($password) < 8) {
    header('Location: register.php?error=Password must be at least 8 characters');
    exit;
  }

  // Check if user already exists
  $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE user_email = ?');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->bind_result($num_rows);
  $stmt->store_result();
  $stmt->fetch();

  if ($num_rows != 0) {
    header('Location: register.php?error=User with this email already exists');
    exit;
  }

  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert new user
  $stmt = $conn->prepare('INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)');
  $stmt->bind_param('sss', $name, $email, $hashed_password);

  if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $name;
    $_SESSION['logged_in'] = true;
    header('Location: account.php?register_success=You Registered Successfully');
    exit;
  } else {
    header('Location: register.php?error=Could not create an account at the moment');
    exit;
  }
}
?>


<?php include('layout/header.php') ?>

    
    <!--Register Page-->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="register.php" method="post" id="register-form">
             <p style="color: red;"><?php if(isset($_GET['error'])) {echo $_GET['error'];}?></p>   
            <div class="form-group">
                    <label for="" class="email">Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required> 
                </div>
                <div class="form-group">
                    <label for="" class="">Email</label>
                    <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required> 
                </div>
                <div class="form-group">
                    <label for="" class="">Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required> 
                </div>
                <div class="form-group">
                    <label for="" class="">Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required> 
                </div>
                <div class="form-group">
                    <input type="submit" class="login-btn py-1 rounded-2" id="register-btn" name="register" value="Register"> 
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you Have an Account? Login</a>
                </div>
            </form>
        </div>
    </section>

    <?php include('layout/footer.php') ?>
