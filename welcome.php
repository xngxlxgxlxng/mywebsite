<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$booking_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_flight'])) {
    $from = $_POST['from_location'];
    $to = $_POST['to_location'];
    $date = $_POST['flight_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, from_location, to_location, flight_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $from, $to, $date);

    if ($stmt->execute()) {
        $booking_message = "Flight booked successfully!";
    } else {
        $booking_message = "Failed to book flight. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Welcome</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<header>
  <nav>
    <a href="index.html" class="logo">Simple Flight Booking</a>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

  <?php if ($booking_message) echo "<p style='color: green;'>$booking_message</p>"; ?>

  <h2>Book a Flight</h2>
  <form method="post" action="">
    <label>From:</label><br />
    <input type="text" name="from_location" required placeholder="Departure city" />
    <br><br>
    <label>To:</label><br />
    <input type="text" name="to_location" required placeholder="Destination city" />
    <br><br>
    <label>Date:</label><br />
    <input type="date" name="flight_date" required />
    <br><br>
    <button type="submit" name="book_flight">Book Flight</button>
  </form>
</main>

</body>
</html>
