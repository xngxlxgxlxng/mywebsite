<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password (no hashing)

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
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Flight Booking</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #333;
      position: relative;
      overflow: hidden;
      background: none;
    }
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('images/background.png') no-repeat center center fixed;
      background-size: cover;
      filter: blur(6px);
      z-index: -1;
    }
    .register-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 45px 35px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      width: 360px;
      text-align: center;
      transition: box-shadow 0.3s ease;
    }
    .register-container:hover {
      box-shadow: 0 12px 32px rgba(0,0,0,0.2);
    }
    h1 {
      margin-bottom: 28px;
      font-weight: 600;
      font-size: 28px;
      color: rgb(0, 0, 0);
      letter-spacing: 1.1px;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px 15px;
      margin: 14px 0 22px;
      border: 1.8px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.25s ease;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #0d8ddb;
      outline: none;
      box-shadow: 0 0 6px rgba(13, 141, 219, 0.5);
    }
    button {
      width: 100%;
      padding: 14px 0;
      background-color: #0d8ddb;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: 0.9px;
      box-shadow: 0 4px 14px rgba(13, 141, 219, 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    button:hover {
      background-color: #0b76bc;
      box-shadow: 0 6px 20px rgba(11, 118, 188, 0.6);
    }
    button:focus {
      outline: none;
      box-shadow: 0 0 10px rgba(13, 141, 219, 0.8);
    }
    p.message {
      margin: 16px 0 0;
      color: #2e7d32;
      font-weight: 600;
      font-size: 15px;
    }
    p.error {
      margin: 16px 0 0;
      color: #d32f2f;
      font-weight: 600;
      font-size: 15px;
    }
    a {
      color: #0d8ddb;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    a:hover {
      text-decoration: underline;
      color: #0b76bc;
    }
    p {
      margin: 14px 0 0;
      font-size: 14px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h1>Register</h1>
    <?php 
      if ($message) {
          $class = strpos($message, 'successful') !== false ? 'message' : 'error';
          echo "<p class='$class'>$message</p>"; 
      }
    ?>
    <form method="POST" action="register.php" novalidate>
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
    <p><a href="index.php">Back to Home</a></p>
  </div>
</body>
</html>
