<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php'; // DB connection

// Check login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first to book an event!";
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST['event_id'])) {

        $user_id = $_SESSION['user_id'];
        $event_id = (int) $_POST['event_id'];

        // Check if this booking already exists (optional)
        $check = $conn->prepare("SELECT * FROM tbl_event_registrations WHERE user_id=? AND event_id=?");
        $check->bind_param("ii", $user_id, $event_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "❌ You have already booked this event!";
        } else {
            // Insert booking
            $stmt = $conn->prepare(
                "INSERT INTO tbl_event_registrations (user_id, event_id, registration_status) VALUES (?, ?, 'pending')"
            );
            $stmt->bind_param("ii", $user_id, $event_id);

            if ($stmt->execute()) {
                $message = "✅ Booking Successful!";
            } else {
                $message = "❌ Booking Failed. Error: ".$stmt->error;
            }

            $stmt->close();
        }

        $check->close();

    } else {
        $message = "❌ Please select an event.";
    }
}

// Fetch events for dropdown
$events = [];
$result = $conn->query("SELECT event_id, event_name FROM tbl_event_details ORDER BY event_name");


if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Event | EventMaster</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-form-container">
    <div class="form-container">
        <h2>Book Your Event</h2>

        <?php if (!empty($message)): ?>
            <p class="success-msg"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post">
           <select name="event_id" required>
    <option value="">-- Select Event --</option>
    <?php foreach ($events as $event): ?>
        <option value="<?= $event['event_id']; ?>">
            <?= htmlspecialchars($event['event_name']); ?>
        </option>
    <?php endforeach; ?>
</select>



            <button type="submit" class="btn">Book Now</button>
        </form>

        <div class="form-footer">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
