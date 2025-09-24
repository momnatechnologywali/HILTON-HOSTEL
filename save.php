<?php
// File: save.php
// Save destination to wishlist
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id'] || !$_GET['dest_id']) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
 
$user_id = $_SESSION['user_id'];
$dest_id = $_GET['dest_id'];
 
try {
    $stmt = $pdo->prepare("INSERT IGNORE INTO saved_destinations (user_id, destination_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $dest_id]);
    echo "<script>alert('Saved!'); window.location.href='search.php';</script>";
} catch (PDOException $e) {
    echo "<script>alert('Error saving.');</script>";
}
?>
