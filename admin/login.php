<?php 
session_start();
include("../server/connection.php");
if (isset($_SESSION['admin_logged_in'])) {
   header('Location: index.php');
   exit;
}

if (isset($_POST['login_btn'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password']; // Raw password

  // Step 1: Get the stored password from DB for the email
  $stmt = $conn->prepare('SELECT admin_id, admin_name, admin_email, admin_password FROM admin2 WHERE admin_email = ? LIMIT 1');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->store_result();

  // If user with this email exists
  if ($stmt->num_rows == 1) {
    $stmt->bind_result($admin_id, $admin_name, $admin_email, $stored_password);
    $stmt->fetch();

    // Check if password in DB is hashed or still plain text
    if (password_verify($password, $stored_password)) {
      // ✅ Password is already hashed and correct
      $_SESSION['admin_id'] = $admin_id;
      $_SESSION['admin_name'] = $admin_name;
      $_SESSION['admin_email'] = $admin_email;
      $_SESSION['admin_logged_in'] = true;

      header('Location: index.php?login_success=Logged in successfully');
      exit;
    } elseif ($password === $stored_password) {
      // 🛑 Password in DB is still in plain text, so hash it now
      $hashed = password_hash($stored_password, PASSWORD_DEFAULT);
      $update = $conn->prepare("UPDATE admin2 SET admin_password = ? WHERE admin_id = ?");
      $update->bind_param('si', $hashed, $admin_id);
      $update->execute();

      // Re-check with the new hashed password
      if (password_verify($password, $hashed)) {
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_logged_in'] = true;

        header('Location: index.php?login_success=Logged in successfully');
        exit;
      }
    }

    // ❌ Incorrect password
    header('Location: login.php?error=Invalid email or password');
    exit;

  } else {
    // ❌ No user found
    header('Location: login.php?error=Invalid email or password');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(135deg, #3498db, #9b59b6);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-container {
      background-color: #fff;
      padding: 2.5rem 2rem;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: #333;
    }

    .login-container form {
      display: flex;
      flex-direction: column;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
      font-size: 0.95rem;
    }

    input[type="email"],
    input[type="password"] {
      padding: 0.75rem;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    .login-btn {
      background-color: #3498db;
      color: white;
      font-weight: bold;
      padding: 0.7rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-btn:hover {
      background-color: #2980b9;
    }

    .error-msg {
      color: red;
      text-align: center;
      margin-bottom: 1rem;
      font-weight: bold;
    }

    @media (max-width: 500px) {
      .login-container {
        margin: 1rem;
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Admin Login</h2>
    <?php if (isset($_GET['error'])): ?>
      <p class="error-msg"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="login.php" method="post" id="login-form">
      <div class="form-group">
        <label for="login-email">Email</label>
        <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="form-group">
        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
      </div>

      <div class="form-group">
        <input type="submit" class="login-btn" name="login_btn" value="Login">
      </div>
    </form>
  </div>

</body>
</html>

    
