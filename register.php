<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Check if user exists
  $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
  $stmt->bind_param("ss", $username, $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $message = "Username or email already exists.";
  } else {
    $stmt->close();
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
      $message = "Registration successful! <a href='login.php'>Login here</a>.";
    } else {
      $message = "Registration failed. Try again.";
    }
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<h2>Register</h2>

<?php if ($message) echo "<p>$message</p>"; ?>

<form method="post" action="">
  <label>Username:</label><br />
  <input type="text" name="username" required /><br><br>
  <label>Email:</label><br />
  <input type="email" name="email" required /><br><br>
  <label>Password:</label><br />
  <input type="password" name="password" required /><br><br>
  <button type="submit">Register</button>
</form>

<p><a href="index.html">Back to Home</a></p>

</body>
</html>
