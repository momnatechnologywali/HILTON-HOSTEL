<?php
// File: blog.php
// Travel guide and blog section
 
include 'db.php';
 
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 10");
$blogs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 20px; }
        .blogs { max-width: 800px; margin: 2rem auto; }
        .blog-card { background: white; margin-bottom: 2rem; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .blog-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem; }
        .blog-card h3 { margin-bottom: 1rem; }
        nav { position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 1rem; z-index: 1000; }
        nav a { color: white; margin: 0 1rem; text-decoration: none; }
        @media (max-width: 768px) { .blog-card { padding: 1rem; } }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="search.php">Search</a>
        <?php if (isset($_SESSION['user_id'])): ?><a href="dashboard.php">Dashboard</a><?php endif; ?>
    </nav>
 
    <section class="blogs">
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-card">
                <?php if ($blog['image_url']): ?><img src="<?= $blog['image_url'] ?>" alt="<?= $blog['title'] ?>"><<?php endif; ?>
                <h3><?= $blog['title'] ?></h3>
                <p><?= substr($blog['content'], 0, 200) ?>...</p>
                <a href="#" onclick="readMore(<?= $blog['id'] ?>)">Read More</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button onclick="saveArticle(<?= $blog['id'] ?>)" style="float: right; background: #28a745; color: white; padding: 0.5rem; border: none; border-radius: 5px; cursor: pointer;">Save</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
 
    <script>
        function readMore(id) {
            // For full article, could load via AJAX or separate page
            alert('Full article view not implemented in this clone.');
        }
        function saveArticle(id) {
            window.location.href = 'save_article.php?id=' + id;
        }
    </script>
</body>
</html>
