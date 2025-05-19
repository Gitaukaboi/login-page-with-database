<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "login_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  

  // Prevent SQL injection
  $username = $conn->real_escape_string($username);
  $password = $conn->real_escape_string($password);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $_SESSION["username"] = $username;
    header("Location: welcome.php");
    exit();
  } else {
    $error = "Invalid username or password!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>PHP Login</title>
  <style>
    body {
      font-family: Arial;
      background: #f4f4f4;
    }

    .login-box {
      width: 300px;
      margin: 100px auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      border-radius: 10px;
    }

    .login-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }

    .login-box button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Login</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
  </form>
  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</div>

</body>
</html>
