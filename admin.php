<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
<p>This is your dashboard.</p>
<a href="logout.php"><button>Logout</button></a>
</body>
</html>
