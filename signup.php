<?php
// File: signup.php
// User signup system
 
session_start();
include 'db.php';
 
if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        echo "<script>alert('Signup successful!'); window.location.href='dashboard.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - HILTON HOSTEL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        form { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 400px; }
        input { width: 100%; padding: 0.75rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; background: #667eea; color: white; padding: 0.75rem; border: none; border-radius: 5px; cursor: pointer; margin-top: 1rem; }
        button:hover { background: #5a67d8; }
        a { text-align: center; display: block; margin-top: 1rem; color: #667eea; text-decoration: none; }
        @media (max-width: 768px) { form { margin: 1rem; } }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
        <a href="login.php">Already have an account? Login</a>
        <a href="index.php" style="margin-top: 0.5rem;">Back to Home</a>
    </form>
</body>
</html>
