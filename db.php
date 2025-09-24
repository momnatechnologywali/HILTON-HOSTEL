<?php
// File: db.php
// Database connection file for HILTON HOSTEL
// Credentials provided: DB: dbsuzjbstpjtrr, User: um4u5gpwc3dwc, Pass: neqhgxo10ioe
 
$host = 'localhost';  // Assuming standard MySQL host; adjust if needed
$dbname = 'dbsuzjbstpjtrr';
$username = 'um4u5gpwc3dwc';
$password = 'neqhgxo10ioe';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
 
// Function to generate confirmation code
function generateConfirmationCode() {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
}
 
// Function to send email (simple mail; use PHPMailer for production)
function sendConfirmationEmail($email, $code, $tripName) {
    $subject = "Booking Confirmation - HILTON HOSTEL";
    $message = "Your booking for $tripName is confirmed! Code: $code";
    mail($email, $subject, $message);
}
?>
