<?php
// File: review.php
// Review and rating system for booked trips
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id']) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
 
$booking_id = $_GET['booking_id'] ?? 0;
if ($_POST && $booking_id) {
    $user_id = $_SESSION['user_id'];
    $trip_id = $_POST['trip_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
 
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, trip_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $trip_id, $rating, $comment]);
 
    echo "<script>alert('Review submitted!'); window.location.href='dashboard.php';</script>";
}
 
// Fetch booking details for review
$stmt = $pdo->prepare("SELECT b.trip_id FROM bookings b WHERE b.id = ? AND b.user_id = ?");
$stmt->execute([$booking_id, $_SESSION['user_id']]);
$booking = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Trip - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        form { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 500px; }
        input, textarea, select { width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; background: #28a745; color: white; padding: 0.75rem; border: none; border-radius: 5px; cursor: pointer; margin-top: 1rem; }
        nav { position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; z-index: 1000; }
        nav a { color: white; margin: 0 1rem; text-decoration: none; }
        @media (max-width: 768px) { form { margin: 1rem; } }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
 
    <?php if ($booking): ?>
    <form method="POST">
        <h2>Rate Your Trip</h2>
        <input type="hidden" name="trip_id" value="<?= $booking['trip_id'] ?>">
        <select name="rating" required>
            <option value="">Select Rating</option>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
        <textarea name="comment" placeholder="Your review..." rows="5"></textarea>
        <button type="submit">Submit Review</button>
    </form>
    <?php else: ?>
        <p style="text-align: center; color: white;">Invalid booking.</p>
    <?php endif; ?>
</body>
</html>
