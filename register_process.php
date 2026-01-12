<?php
session_start();
require 'db.php'; // Make sure db.php connects to event_management_system

if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
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
        $_SESSION['success'] = "Registration Successful! You can now login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        header("Location: register.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
