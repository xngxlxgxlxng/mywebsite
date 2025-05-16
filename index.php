<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Welcome to Simple Flight Booking</h1>
  <p><a href="register.php">Register</a> | <a href="login.php">Login</a></p>
</body>
</html>
