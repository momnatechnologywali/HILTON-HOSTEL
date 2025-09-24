<?php
// File: booking.php
// Trip booking system
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id']) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
 
$trip_id = $_GET['id'] ?? 0;
if ($trip_id) {
    $stmt = $pdo->prepare("SELECT t.*, d.name as dest_name FROM trips t JOIN destinations d ON t.destination_id = d.id WHERE t.id = ?");
    $stmt->execute([$trip_id]);
    $trip = $stmt->fetch();
}
 
if ($_POST && $trip) {
    $user_id = $_SESSION['user_id'];
    $booking_date = $_POST['booking_date'];
    $total_price = $trip['price'];
    $code = generateConfirmationCode();
 
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, trip_id, booking_date, total_price, confirmation_code) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $trip_id, $booking_date, $total_price, $code]);
 
    // Update availability
    $pdo->prepare("UPDATE trips SET availability = availability - 1 WHERE id = ?")->execute([$trip_id]);
 
    $user_stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user = $user_stmt->fetch();
    sendConfirmationEmail($user['email'], $code, $trip['name']);
 
    echo "<script>alert('Booking confirmed! Code: $code'); window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Trip - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 20px; }
        .booking-form { background: white; max-width: 600px; margin: 2rem auto; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        input { width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; background: #28a745; color: white; padding: 0.75rem; border: none; border-radius: 5px; cursor: pointer; margin-top: 1rem; }
        .trip-details { background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        nav { position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; z-index: 1000; }
        nav a { color: white; margin: 0 1rem; text-decoration: none; }
        @media (max-width: 768px) { .booking-form { margin: 1rem; } }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
 
    <?php if ($trip): ?>
    <div class="booking-form">
        <h2>Book <?= $trip['name'] ?> in <?= $trip['dest_name'] ?></h2>
        <div class="trip-details">
            <p>Price: $<?= $trip['price'] ?></p>
            <p>Duration: <?= $trip['duration'] ?> days</p>
            <p>Availability: <?= $trip['availability'] ?> spots left</p>
        </div>
        <form method="POST">
            <input type="date" name="booking_date" required>
            <button type="submit">Confirm Booking</button>
        </form>
        <a href="search.php" style="display: block; text-align: center; margin-top: 1rem; color: #667eea;">Back to Search</a>
    </div>
    <?php else: ?>
        <p style="text-align: center; color: white;">Trip not found.</p>
        <script>window.location.href='search.php';</script>
    <?php endif; ?>
</body>
</html>
