<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: url('background.avif') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    .overlay {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 0;
    }

    .content {
      position: relative;
      z-index: 1;
      max-width: 400px;
      background: rgba(0, 0, 0, 0.6);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.7);
    }

    h1 {
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 2.5rem;
      letter-spacing: 1.5px;
    }

    form {
      display: flex;
      flex-direction: column;
      text-align: left;
    }

    label {
      margin: 10px 0 5px;
      font-weight: 600;
    }

    input {
      padding: 10px;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
      margin-bottom: 15px;
    }

    button {
      padding: 12px;
      background-color: #00b4d8;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: 700;
      cursor: pointer;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #90e0ef;
    }

    p.links {
      margin-top: 20px;
      font-weight: 600;
    }

    p.links a {
      color: #00b4d8;
      text-decoration: none;
      margin: 0 10px;
    }

    p.links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="content">
    <h1>Login</h1>
    <form method="POST" action="login_process.php">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required />

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required />

      <button type="submit">Login</button>
    </form>
    <p class="links">
      Don't have an account? <a href="register.php">Register</a><br />
      <a href="index.php">Back to Home</a>
    </p>
  </div>
</body>
</html>
