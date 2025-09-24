<?php
// File: unsave.php
// Remove from wishlist
 
session_start();
include 'db.php';
 
if (!$_SESSION['user_id'] || !$_GET['dest_id']) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
 
$user_id = $_SESSION['user_id'];
$dest_id = $_GET['dest_id'];
 
$stmt = $pdo->prepare("DELETE FROM saved_destinations WHERE user_id = ? AND destination_id = ?");
$stmt->execute([$user_id, $dest_id]);
 
echo "<script>alert('Removed!'); window.location.href='dashboard.php';</script>";
?>
