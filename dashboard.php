<?php
// File: dashboard.php
// User dashboard for trip management and saved destinations
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id']) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
 
$user_id = $_SESSION['user_id'];
 
// Fetch upcoming trips (bookings)
$stmt = $pdo->prepare("SELECT b.*, t.name as trip_name, d.name as dest_name FROM bookings b JOIN trips t ON b.trip_id = t.id JOIN destinations d ON t.destination_id = d.id WHERE b.user_id = ? AND b.status = 'confirmed' ORDER BY b.booking_date ASC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
 
// Fetch saved destinations
$stmt = $pdo->prepare("SELECT sd.*, d.name, d.image_url FROM saved_destinations sd JOIN destinations d ON sd.destination_id = d.id WHERE sd.user_id = ?");
$stmt->execute([$user_id]);
$saved = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 80px 20px 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .section { background: white; margin-bottom: 2rem; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        h2 { margin-bottom: 1rem; color: #333; }
        .booking-list, .saved-list { display: grid; gap: 1rem; }
        .item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #667eea; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #5a67d8; }
        a { color: #667eea; text-decoration: none; }
        nav { position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; z-index: 1000; }
        nav a { color: white; margin: 0 1rem; text-decoration: none; }
        @media (max-width: 768px) { .item { flex-direction: column; align-items: flex-start; } }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="search.php">Search Trips</a>
        <a href="blog.php">Blog</a>
        <a href="#" onclick="logout()">Logout</a>
    </nav>
 
    <div class="container">
        <div class="section">
            <h2>Upcoming Trips</h2>
            <div class="booking-list">
                <?php foreach ($bookings as $booking): ?>
                    <div class="item">
                        <span><?= $booking['trip_name'] ?> in <?= $booking['dest_name'] ?> - <?= $booking['booking_date'] ?></span>
                        <span>Status: <?= ucfirst($booking['status']) ?></span>
                        <button onclick="window.location.href='review.php?booking_id=<?= $booking['id'] ?>'">Review</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
 
        <div class="section">
            <h2>Saved Destinations</h2>
            <div class="saved-list">
                <?php foreach ($saved as $item): ?>
                    <div class="item">
                        <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>" style="width: 50px; height: 50px; object-fit: cover; margin-right: 1rem;">
                        <span><?= $item['name'] ?></span>
                        <button onclick="unsave(<?= $item['destination_id'] ?>)">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
 
    <script>
        function logout() {
            if (confirm('Logout?')) window.location.href = 'logout.php';
        }
        function unsave(dest_id) {
            if (confirm('Remove from saved?')) {
                // AJAX or form post to remove; for simplicity, redirect to unsave.php
                window.location.href = 'unsave.php?dest_id=' + dest_id;
            }
        }
    </script>
</body>
</html>
