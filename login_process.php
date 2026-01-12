<?php
session_start();
require 'db.php'; // Connects to event_management_system

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT user_id, password, user_role FROM tbl_user_accounts WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $user_role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $user_role;
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }

    } else {
        $_SESSION['error'] = "No account found with that email!";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}
?>
