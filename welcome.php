<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "mywebsite");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $from = $conn->real_escape_string($_POST['from_location']);
    $to = $conn->real_escape_string($_POST['to_location']);
    $date = $_POST['flight_date'];

    // 🔍 Check if user exists
    $checkUser = $conn->query("SELECT id FROM users WHERE id = '$user_id'");
    if ($checkUser->num_rows > 0) {
        // ✅ Proceed with booking
        $sql = "INSERT INTO bookings (user_id, from_location, to_location, flight_date, booked_at)
                VALUES ('$user_id', '$from', '$to', '$date', NOW())";

        if ($conn->query($sql) === TRUE) {
            $message = "Booking successful!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        // ❌ Invalid user ID (probably tampered or not logged in properly)
        $message = "Error: Invalid user session. Please log in again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Book a Flight</title>
  <style>
    /* Your existing CSS (unchanged) */
    html, body {
      margin: 0; padding: 0; height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('images/background.png') no-repeat center center fixed;
      background-size: cover;
      filter: blur(8px);
      z-index: -1;
    }

    .container {
      position: fixed;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(255, 255, 255, 0.95);
      padding: 40px 50px;
      border-radius: 12px;
      max-width: 460px;
      width: 90%;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      text-align: center;
      box-sizing: border-box;
    }

    h2 {
      margin: 0 0 32px 0;
      font-size: 2.25rem;
      font-weight: 700;
      color: #34495e;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      font-size: 15px;
      color: #34495e;
      text-align: left;
    }

    form input, form datalist {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 20px;
      border: 1.5px solid #bdc3c7;
      border-radius: 6px;
      font-size: 16px;
      color: #2c3e50;
      background-color: #fafafa;
      transition: border-color 0.25s ease;
      box-sizing: border-box;
    }

    form input::placeholder {
      color: #95a5a6;
    }

    form input:focus {
      border-color: #0d8ddb;
      outline: none;
      background-color: #fff;
    }

    button[type="submit"] {
      display: block;
      margin: 30px auto 0 auto;
      padding: 16px 40px;
      background-color: #0d8ddb;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 10px rgba(13, 141, 219, 0.4);
      user-select: none;
    }

    button[type="submit"]:hover {
      background-color: #0b76bc;
      box-shadow: 0 6px 15px rgba(11, 118, 188, 0.5);
    }

    .message, .error {
      font-weight: 600;
      font-size: 1rem;
      margin-bottom: 24px;
      padding: 12px 18px;
      border-radius: 8px;
      user-select: none;
      text-align: center;
    }

    .message {
      background-color: #d4edda;
      color: #155724;
      border: 1.5px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1.5px solid #f5c6cb;
    }

    .logout-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 10px 22px;
      font-weight: 600;
      font-size: 0.9rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.25);
      z-index: 10;
    }

    .logout-btn:hover {
      background-color: rgb(0, 0, 0);
    }

    @media (max-width: 480px) {
      .container {
        padding: 30px 24px;
        width: 95%;
        border-radius: 10px;
      }

      .logout-btn {
        padding: 8px 18px;
        font-size: 0.85rem;
        bottom: 12px;
        right: 12px;
      }

      h2 {
        font-size: 1.8rem;
      }

      button[type="submit"] {
        font-size: 1rem;
        padding: 14px 30px;
        margin-top: 25px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <form method="post" action="">
    <h2>Book a Flight</h2>

    <?php if ($message): ?>
      <p class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>">
        <?php echo htmlspecialchars($message); ?>
      </p>
    <?php endif; ?>

    <label for="from_location">From Location</label>
    <input list="places" id="from_location" name="from_location" placeholder="Enter departure city" required>

    <label for="to_location">To Location</label>
    <input list="places" id="to_location" name="to_location" placeholder="Enter destination city" required>

    <label for="flight_date">Flight Date</label>
    <input type="date" id="flight_date" name="flight_date" required>

    <button type="submit">Book Now</button>

    <datalist id="places">
      <option value="Asunción">
      <option value="Bangkok">
      <option value="Berlin">
      <option value="Bogotá">
      <option value="Buenos Aires">
      <option value="Caracas">
      <option value="Cebu City">
      <option value="Davao City">
      <option value="Dubai">
      <option value="Hanoi">
      <option value="Ho Chi Minh City">
      <option value="Jakarta">
      <option value="Kuala Lumpur">
      <option value="Lima">
      <option value="London">
      <option value="Los Angeles">
      <option value="Madrid">
      <option value="Manila">
      <option value="Montevideo">
      <option value="New York">
      <option value="Paris">
      <option value="Phnom Penh">
      <option value="Philippines">
      <option value="Quezon City">
      <option value="Quito">
      <option value="Rio de Janeiro">
      <option value="Santiago">
      <option value="São Paulo">
      <option value="Singapore">
      <option value="Toronto">
      <option value="Vientiane">
      <option value="Sydney">
      <option value="Tokyo">
      <option value="Yangon">
    </datalist>
  </form>
</div>

<button class="logout-btn" onclick="location.href='logout.php'">Logout</button>

</body>
</html>
