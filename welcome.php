<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$booking_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
<html>
<head>
  <title>Welcome - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <p><a href="logout.php">Logout</a></p>

  <?php if ($booking_message) echo "<p>$booking_message</p>"; ?>

  <h2>Book a Flight</h2>
  <form method="POST" action="welcome.php">
    <input type="text" name="from_location" placeholder="From" required /><br><br>
    <input type="text" name="to_location" placeholder="To" required /><br><br>
    <input type="date" name="flight_date" required /><br><br>
    <button type="submit">Book Flight</button>
  </form>
</body>
</html>
