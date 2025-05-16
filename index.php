<?php
session_start();
include 'db.php';

$message = "";
$booking_message = "";

// Handle registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Username or email already exists.";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $message = "Registration successful! Please login.";
        } else {
            $message = "Registration failed. Try again.";
        }
    }
    $stmt->close();
}

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $message = "Logged in successfully!";
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "User not found.";
    }
    $stmt->close();
}

// Handle flight booking
if (isset($_POST['book_flight'])) {
    if (!isset($_SESSION['user_id'])) {
        $message = "You must be logged in to book flights.";
    } else {
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
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Simple Flight Booking</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>

<header>
  <nav>
    <a href="index.php" class="logo">Simple Flight Booking</a>
    <ul>
      <li><a href="index.php">Home</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="index.php?logout=true">Logout</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main>
  <?php if ($message) echo "<p class='message'>$message</p>"; ?>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <h1>Welcome to Simple Flight Booking</h1>
    <p>Plan your next flight easily.</p>

    <h2>Register</h2>
    <form method="post" action="index.php">
      <input type="text" name="username" placeholder="Username" required /><br><br>
      <input type="email" name="email" placeholder="Email" required /><br><br>
      <input type="password" name="password" placeholder="Password" required /><br><br>
      <button type="submit" name="register">Register</button>
    </form>

    <h2>Login</h2>
    <form method="post" action="index.php">
      <input type="text" name="username" placeholder="Username" required /><br><br>
      <input type="password" name="password" placeholder="Password" required /><br><br>
      <button type="submit" name="login">Login</button>
    </form>

  <?php else: ?>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <?php if ($booking_message) echo "<p class='message'>$booking_message</p>"; ?>

    <h2>Book a Flight</h2>
    <form method="post" action="index.php">
      <input type="text" name="from_location" placeholder="From" required /><br><br>
      <input type="text" name="to_location" placeholder="To" required /><br><br>
      <input type="date" name="flight_date" required /><br><br>
      <button type="submit" name="book_flight">Book Flight</button>
    </form>
  <?php endif; ?>
</main>

</body>
</html>
