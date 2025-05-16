<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Username or Email already exists.";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $message = "Registration successful! <a href='login.php'>Login here</a>.";
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Register</h1>
  <?php if ($message) echo "<p>$message</p>"; ?>
  <form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Username" required /><br><br>
    <input type="email" name="email" placeholder="Email" required /><br><br>
    <input type="password" name="password" placeholder="Password" required /><br><br>
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login here</a></p>
  <p><a href="index.php">Back to Home</a></p>
</body>
</html>
