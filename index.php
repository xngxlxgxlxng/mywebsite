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
  <title>Home - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: url('background.avif') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      z-index: 0;
    }

    .content {
      position: relative;
      z-index: 1;
      max-width: 400px;
      width: 90%;
      background: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      color: #fff;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .content:hover {
      transform: scale(1.02);
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 30px;
      font-weight: 700;
      letter-spacing: 1.2px;
    }

    .btn-link {
      display: inline-block;
      padding: 12px 24px;
      margin: 10px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      color: #fff;
      background: linear-gradient(135deg, #00b4d8, #0077b6);
      border-radius: 30px;
      transition: all 0.3s ease;
    }

    .btn-link:hover {
      background: linear-gradient(135deg, #90e0ef, #00b4d8);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="content">
    <h1>Flight Booking</h1>
    <a href="register.php" class="btn-link">Register</a>
    <a href="login.php" class="btn-link">Login</a>
  </div>
</body>
</html>
