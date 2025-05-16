<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $hashed_password);

  if ($stmt->num_rows == 1) {
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $username;
      header("Location: welcome.php");
      exit;
    } else {
      $message = "Incorrect password.";
    }
  } else {
    $message = "User not found.";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<h2>Login</h2>

<?php if ($message) echo "<p>$message</p>"; ?>

<form method="post" action="">
  <label>Username:</label><br />
  <input type="text" name="username" required /><br><br>
  <label>Password:</label><br />
  <input type="password" name="password" required /><br><br>
  <button type="submit">Login</button>
</form>

<p><a href="register.php">Don't have an account? Register here.</a></p>
<p><a href="index.html">Back to Home</a></p>

</body>
</html>
