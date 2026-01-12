<?php
session_start();
require 'db.php'; // Connects to event_management_system

// Handle form submission
if (isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
    } else {
        // Insert into database securely
        $stmt = $conn->prepare("INSERT INTO tbl_contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Redirect to avoid form resubmission
    header("Location: contact.php");
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | EventMaster</title>
<link rel="stylesheet" href="professional.css">
<style>
    .form-container {
        max-width: 500px;
        margin: 80px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    .form-container h2 { color: #333; margin-bottom: 20px; }
    .form-container input, .form-container textarea {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    .form-container button {
        background-color: #ff4b2b;
        color: #fff;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }
    .form-container button:hover { background-color: #ff416c; }
    .form-container .error { color: red; margin-bottom: 15px; }
    .form-container .success { color: green; margin-bottom: 15px; }
    .form-footer { margin-top: 15px; }
    .form-footer a { color: #ff4b2b; text-decoration: none; }
</style>
</head>
<body>

<div class="form-container">
    <h2>Contact Us</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
        <button type="submit" name="submit">Send Message</button>
    </form>

    <div class="form-footer">
        <a href="index.html">Back to Home</a>
    </div>
</div>

</body>
</html>
