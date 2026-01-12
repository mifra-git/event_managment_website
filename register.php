<?php
session_start();
require 'db.php'; // Connect to event_management_system

// Handle form submission
if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($full_name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: register.php");
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM tbl_user_accounts WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already registered!";
        $stmt->close();
        header("Location: register.php");
        exit();
    }
    $stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO tbl_user_accounts (full_name, email, password, user_role) VALUES (?, ?, ?, 'customer')");
    $stmt->bind_param("sss", $full_name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! You can login now.";
        header("Location: register.php"); // Reload to show success
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again!";
        header("Location: register.php");
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - EventMaster</title>
<link rel="stylesheet" href="professional.css">
</head>
<body>

<div class="form-container">
    <h2>Create an Account</h2>

    <!-- Display messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Registration form -->
    <form action="" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>

    <div class="form-footer">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
