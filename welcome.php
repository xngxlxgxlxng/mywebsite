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
  <title>Welcome - Flight Booking</title>
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

    .container {
      position: relative;
      z-index: 1;
      max-width: 400px;
      background: rgba(0, 0, 0, 0.6);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.7);

      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 520px;
    }

    h1 {
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 2.5rem;
      letter-spacing: 1.5px;
    }

    form {
      text-align: left;
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      display: block;
      margin: 15px 0 5px;
    }

    select, input[type="datetime-local"] {
      width: 100%;
      padding: 10px;
      border-radius
