<?php
// File: index.php
// Homepage showcasing popular destinations, deals, and experiences
// Includes trending destinations and travel tips
 
session_start();
include 'db.php';
 
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = null;  // Guest mode
}
 
// Fetch trending destinations
$stmt = $pdo->query("SELECT * FROM destinations WHERE is_trending = TRUE LIMIT 6");
$destinations = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HILTON HOSTEL - Discover Your Next Adventure</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        header { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; position: fixed; width: 100%; top: 0; z-index: 1000; }
        nav { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; }
        nav a { color: white; text-decoration: none; margin: 0 1rem; font-weight: bold; transition: color 0.3s; }
        nav a:hover { color: #ffd700; }
        .login-btn { background: #ffd700; color: #333; padding: 0.5rem 1rem; border-radius: 20px; }
        .hero { background: url('https://example.com/hero-bg.jpg') center/cover; height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; color: white; margin-top: 60px; }
        .hero h1 { font-size: 4rem; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .search-bar { background: rgba(255,255,255,0.9); padding: 2rem; border-radius: 50px; max-width: 600px; margin: 2rem auto; }
        .search-bar input { padding: 0.5rem; margin: 0 0.5rem; border: none; border-radius: 5px; width: 200px; }
        .search-btn { background: #ffd700; color: #333; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        .destinations { max-width: 1200px; margin: 4rem auto; padding: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .dest-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: transform 0.3s; }
        .dest-card:hover { transform: translateY(-10px); }
        .dest-card img { width: 100%; height: 200px; object-fit: cover; }
        .dest-card h3 { padding: 1rem; color: #333; }
        .dest-card p { padding: 0 1rem 1rem; color: #666; }
        .price { font-weight: bold; color: #ffd700; padding: 0 1rem 1rem; }
        .tips { background: white; margin: 4rem auto; max-width: 800px; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        footer { background: #333; color: white; text-align: center; padding: 2rem; margin-top: 4rem; }
        @media (max-width: 768px) { .hero h1 { font-size: 2.5rem; } .search-bar input { width: 100%; margin: 0.5rem 0; } .destinations { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">HILTON HOSTEL</a>
            <div>
                <?php if ($_SESSION['user_id']): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="#" onclick="logout()">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="signup.php" class="login-btn">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
 
    <section class="hero">
        <div>
            <h1>Discover Your Dream Destination</h1>
            <p>Book trips, explore guides, and create memories</p>
        </div>
    </section>
 
    <div class="search-bar">
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search destinations...">
            <select name="type">
                <option value="">All Types</option>
                <option value="adventure">Adventure</option>
                <option value="beach">Beach</option>
                <option value="city">City</option>
            </select>
            <input type="number" name="max_price" placeholder="Max Price">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>
 
    <section class="destinations">
        <h2 style="text-align: center; grid-column: 1/-1; font-size: 2.5rem; margin-bottom: 2rem;">Trending Destinations</h2>
        <?php foreach ($destinations as $dest): ?>
            <div class="dest-card">
                <img src="<?= $dest['image_url'] ?>" alt="<?= $dest['name'] ?>">
                <h3><?= $dest['name'] ?></h3>
                <p><?= substr($dest['description'], 0, 100) ?>...</p>
                <div class="price">$<?= $dest['price'] ?> for <?= $dest['duration'] ?> days</div>
                <button onclick="window.location.href='booking.php?id=<?= $dest['id'] ?>'" style="width: 100%; background: #667eea; color: white; padding: 1rem; border: none; cursor: pointer;">Book Now</button>
            </div>
        <?php endforeach; ?>
    </section>
 
    <section class="tips">
        <h2>Travel Tips</h2>
        <p>Plan your journey with our expert guides. Check out our <a href="blog.php">blog</a> for itineraries and advice.</p>
    </section>
 
    <footer>
        <p>&copy; 2025 HILTON HOSTEL. All rights reserved.</p>
    </footer>
 
    <script>
        function logout() {
            if (confirm('Are you sure?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>
