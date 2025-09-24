<?php
// File: save_article.php
// Save blog article (placeholder for trip plans)
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id'] || !$_GET['id']) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
 
// For simplicity, just alert; extend with a saved_articles table if needed
echo "<script>alert('Article saved to your plans!'); window.location.href='blog.php';</script>";
?>
