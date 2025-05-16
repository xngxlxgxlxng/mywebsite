<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: url('background.avif') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      z-index: 0;
    }

    .container {
      position: relative;
      z-index: 1;
      max-width: 420px;
      width: 90%;
      background: rgba(255, 255, 255, 0.12);
      border-radius: 20px;
      padding: 40px;
      color: white;
      text-align: center;
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    .btn {
      display: inline-block;
      padding: 12px 24px;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      background: linear-gradient(135deg, #00b4d8, #0077b6);
      border: none;
      border-radius: 30px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: linear-gradient(135deg, #90e0ef, #00b4d8);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="container">
    <h1>Welcome to Flight Booking</h1>
    <p>You are successfully logged in.</p>
    <a href="logout.php" class="btn">Logout</a>
  </div>
</body>
</html>
