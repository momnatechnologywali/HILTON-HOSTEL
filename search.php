<?php
// File: search.php
// Trip search and filter system
 
session_start();
include 'db.php';
 
$results = [];
if ($_GET) {
    $query = $_GET['query'] ?? '';
    $type = $_GET['type'] ?? '';
    $max_price = $_GET['max_price'] ?? 999999;
 
    $sql = "SELECT d.*, t.price as trip_price FROM destinations d JOIN trips t ON d.id = t.destination_id WHERE d.name LIKE ? AND (t.type = ? OR ? = '') AND t.price <= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$query%", $type, $type, $max_price]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 20px; }
        .search-form { background: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        input, select { padding: 0.5rem; margin: 0 0.5rem; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #667eea; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        .results { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .result-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .result-card img { width: 100%; height: 200px; object-fit: cover; }
        .result-card h3 { padding: 1rem; }
        nav { position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; z-index: 1000; }
        nav a { color: white; margin: 0 1rem; text-decoration: none; }
        @media (max-width: 768px) { .search-form input, select { width: 100%; margin: 0.5rem 0; } }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <?php if ($_SESSION['user_id']): ?><a href="dashboard.php">Dashboard</a><?php endif; ?>
    </nav>
 
    <div class="search-form">
        <form method="GET">
            <input type="text" name="query" value="<?= $_GET['query'] ?? '' ?>" placeholder="Search...">
            <select name="type">
                <option value="">All</option>
                <option value="adventure">Adventure</option>
                <option value="beach">Beach</option>
                <option value="city">City</option>
            </select>
            <input type="number" name="max_price" value="<?= $_GET['max_price'] ?? '' ?>" placeholder="Max Price">
            <button type="submit">Search</button>
        </form>
    </div>
 
    <section class="results">
        <?php foreach ($results as $result): ?>
            <div class="result-card">
                <img src="<?= $result['image_url'] ?>" alt="<?= $result['name'] ?>">
                <h3><?= $result['name'] ?></h3>
                <p style="padding: 0 1rem;"><?= substr($result['description'], 0, 100) ?>...</p>
                <div style="padding: 1rem; font-weight: bold; color: #ffd700;">$<?= $result['trip_price'] ?></div>
                <button onclick="window.location.href='booking.php?id=<?= $result['id'] ?>'" style="width: 100%; background: #667eea; color: white; padding: 1rem; border: none; cursor: pointer;">Book</button>
                <?php if ($_SESSION['user_id']): ?>
                    <button onclick="save(<?= $result['id'] ?>)" style="width: 100%; background: #28a745; color: white; padding: 0.5rem; border: none; cursor: pointer; margin-top: 0.5rem;">Save</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
 
    <script>
        function save(dest_id) {
            // Simple redirect to save.php
            window.location.href = 'save.php?dest_id=' + dest_id;
        }
    </script>
</body>
</html>
