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
  <style>
    /* Full page background */
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('images/background.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Container for content */
    .container {
      background: rgba(255, 255, 255, 0.9);
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }

    h1 {
      color:rgb(0, 0, 0);
      margin-bottom: 25px;
      font-size: 2.5rem;
      font-weight: 700;
    }

    p {
      font-size: 1.1rem;
      margin-bottom: 35px;
      color: #333;
    }

    a.button {
      display: inline-block;
      background-color: #0d8ddb;
      color: white;
      padding: 14px 30px;
      margin: 0 10px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 10px rgba(13, 141, 219, 0.4);
    }

    a.button:hover {
      background-color: #0b76bc;
      box-shadow: 0 6px 15px rgba(11, 118, 188, 0.5);
    }

    /* Responsive */
    @media (max-width: 450px) {
      .container {
        padding: 30px 20px;
      }

      h1 {
        font-size: 2rem;
      }

      a.button {
        padding: 12px 20px;
        font-size: 0.9rem;
        margin: 8px 5px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Flight Booking</h1>
    <p>Book your flights quickly and easily.</p>
    <a href="register.php" class="button">Register</a>
    <a href="login.php" class="button">Login</a>
  </div>
</body>
</html>
