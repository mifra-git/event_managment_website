<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first!";
    header("Location: login.php");
    exit();
}

// Fetch user details
$stmt = $conn->prepare("SELECT full_name, email FROM tbl_user_accounts WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($full_name, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - EventMaster</title>
<link rel="stylesheet" href="professional.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .dashboard-container {
        max-width: 600px;
        margin: 80px auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
    }

    .dashboard-container h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .dashboard-container p {
        color: #555;
        font-size: 16px;
        margin: 10px 0;
    }

    .dashboard-container a {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 25px;
        background-color: #ff4b2b;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .dashboard-container a:hover {
        background-color: #ff416c;
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>

    <a href="book.php">Book an Event</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
