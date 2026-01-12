<?php
session_start();
require 'db.php'; // Make sure this connects to 'event_management_system'

// Handle contact form submission
if(isset($_POST['submit_contact'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if(empty($name) || empty($email) || empty($message)) {
        $_SESSION['error_contact'] = "Please fill in all fields.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_contact'] = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if($stmt->execute()) {
            $_SESSION['success_contact'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['error_contact'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
    header("Location: index.php#contact"); // Redirect to prevent duplicate submission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- ================= LOGOUT MESSAGE (Optional) ================= -->
<div class="logout-container" id="logout-msg" style="display:none;">
    <h2>Logged Out!</h2>
    <p>You will be redirected to the homepage shortly...</p>
    <a href="index.php">Click here if not redirected</a>
</div>

<!-- ================= HEADER ================= -->
<header>
    <div class="container">
        <h1 class="logo">Eventify</h1>
        <nav>
            <ul>
                <li><a href="#hero">Home</a></li>
                <li><a href="#reviews">Reviews</a></li>
                <li><a href="#events">Book Event</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- ================= HERO ================= -->
<section class="hero" id="hero">
    <div class="hero-content">
        <h1>Make Your Event Unforgettable!</h1>
        <p>Professional planning, seamless execution, and memories that last a lifetime.</p>
        <a href="#events" class="btn">Book Your Event</a>
    </div>
</section>

<!-- ================= UPCOMING EVENTS ================= -->
<section class="featured-events" id="events">
    <div class="container">
        <center class="heading-wrapper">
            <h2 class="section-heading">Upcoming Events</h2>
            <p class="section-subtitle">Don’t miss our amazing events happening soon!</p>
        </center>

 <div class="event-cards">
    <!-- Event 1 -->
    <div class="card">
        <img src="images/Concerts and Music Festivals.jpg" alt="Music Concert">
        <h3>Music Concert</h3>
        <p>Date: 25th Dec 2025</p>
        <p>Join us for an unforgettable night with top artists performing live. Experience music like never before!</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 2 -->
    <div class="card">
        <img src="images/Private Dinners and Banquets.jpg" alt="Food Festival">
        <h3>Food Festival</h3>
        <p>Date: 5th Jan 2026</p>
        <p>Celebrate the love for food with delicious dishes, cooking demos, and fun activities for all ages.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 3 -->
    <div class="card">
        <img src="images/Private Dinners and Banquets.jpg" alt="Tech Expo">
        <h3>Tech Expo</h3>
        <p>Date: 15th Jan 2026</p>
        <p>Explore the latest in technology, innovation, and gadgets. Perfect for tech enthusiasts and professionals.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 4 -->
    <div class="card">
        <img src="images/Art Exhibitions and Gallery Openings.jpg" alt="Art Workshop">
        <h3>Art Workshop</h3>
        <p>Date: 28th Jan 2026</p>
        <p>Learn painting and craft techniques from experienced artists. A creative event for all ages!</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 5 -->
    <div class="card">
        <img src="images/Conferences and Conventions.jpg" alt="Conference">
        <h3>Conferences & Conventions</h3>
        <p>Date: 5th Feb 2026</p>
        <p>Attend inspiring talks and networking sessions with industry experts. Ideal for professionals.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 6 -->
    <div class="card">
        <img src="images/Award Ceremonies.jpg" alt="Award Ceremony">
        <h3>Award Ceremony</h3>
        <p>Date: 20th Feb 2026</p>
        <p>Celebrate achievements and recognize talents with a glamorous award ceremony.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 7 -->
    <div class="card">
        <img src="images/Weddings and Receptions.jpg" alt="Wedding Celebration">
        <h3>Wedding Celebration</h3>
        <p>Date: 1st Mar 2026</p>
        <p>Make your special day unforgettable with a perfectly organized wedding celebration.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 8 -->
    <div class="card">
        <img src="images/Cultural Festivals.jpg" alt="Cultural Festival">
        <h3>Cultural Festival</h3>
        <p>Date: 10th Mar 2026</p>
        <p>Experience vibrant traditions, performances, and activities celebrating diverse cultures.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 9 -->
    <div class="card">
        <img src="images/Corporate Meetups.jpg" alt="Corporate Meetup">
        <h3>Corporate Meetup</h3>
        <p>Date: 20th Mar 2026</p>
        <p>Networking and collaboration for businesses, featuring workshops, speakers, and seminars.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 10 -->
    <div class="card">
        <img src="images/Charity Events.jpg" alt="Charity Event">
        <h3>Charity Event</h3>
        <p>Date: 5th Apr 2026</p>
        <p>Join hands to support meaningful causes and make a difference in the community.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 11 -->
    <div class="card">
        <img src="images/Fashion Shows.jpg" alt="Fashion Show">
        <h3>Fashion Show</h3>
        <p>Date: 15th Apr 2026</p>
        <p>Showcasing top designers and the latest trends in fashion. A glamorous event not to miss!</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
    <!-- Event 12 -->
    <div class="card">
        <img src="images/Outdoor Adventures.jpg" alt="Outdoor Adventure">
        <h3>Outdoor Adventure</h3>
        <p>Date: 25th Apr 2026</p>
        <p>Exciting outdoor activities including team-building exercises and adventure sports.</p>
        <a href="book.php" class="btn">Book Now</a>
    </div>
</div>


<!-- ================= CONTACT FORM ================= -->
<section class="forms-section" id="book-event">
   <div class="form-half contact-half" id="contact">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, please fill out the form below.</p>

        <!-- Display success/error messages -->
        <?php if(isset($_SESSION['error_contact'])): ?>
            <p style="color:red;"><?php echo $_SESSION['error_contact']; unset($_SESSION['error_contact']); ?></p>
        <?php endif; ?>
        <?php if(isset($_SESSION['success_contact'])): ?>
            <p style="color:green;"><?php echo $_SESSION['success_contact']; unset($_SESSION['success_contact']); ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit" name="submit_contact">Send Message</button>
        </form>
        <div class="form-info">We typically respond within 24 hours.</div>
    </div>
</section>
<!-- ================= CUSTOMER REVIEWS ================= -->
<section class="reviews-section" id="reviews">
    <h2 class="section-heading">What Our Customers Say</h2>
    <p class="section-subtitle">We value our customers’ feedback. Here are some reviews from our happy clients.</p>

    <div class="reviews-slider">
        <div class="review-card">
            <p>"Amazing service! The event was perfectly organized and everything went smoothly."</p>
            <h4>– Sarah L.</h4>
        </div>
        <div class="review-card">
            <p>"I loved how professional the team was. Highly recommend for corporate events."</p>
            <h4>– Michael D.</h4>
        </div>
        <div class="review-card">
            <p>"Our wedding was magical thanks to their incredible planning and attention to detail."</p>
            <h4>– Priya & Arjun</h4>
        </div>
        <div class="review-card">
            <p>"Birthday party was fantastic! Kids and adults loved it."</p>
            <h4>– Anjali R.</h4>
        </div>
        <div class="review-card">
            <p>"The anniversary event was beautifully decorated and well-managed."</p>
            <h4>– Rohan & Meera</h4>
        </div>
        <div class="review-card">
            <p>"Corporate meetup exceeded expectations. Excellent arrangements and coordination."</p>
            <h4>– Nimal K.</h4>
        </div>
        <div class="review-card">
            <p>"Food festival was delicious and fun. Great atmosphere and well-organized."</p>
            <h4>– Priya S.</h4>
        </div>
    </div>

    <!-- Slider Navigation -->
    <button class="prev-btn">&#10094;</button>
    <button class="next-btn">&#10095;</button>
</section>

<!-- ================= ABOUT ================= -->
<section class="about-section" id="about">
    <div class="about-wrapper">
        <h2>About Eventify</h2>
        <p>Turning Your Special Moments into Unforgettable Memories</p>
        <p>Eventify is a professional event management service dedicated to planning memorable events.</p>
        <div class="about-highlights">
            <div class="highlight-box">
                <h3>500+</h3>
                <span>Events Managed</span>
            </div>
            <div class="highlight-box">
                <h3>300+</h3>
                <span>Happy Clients</span>
            </div>
            <div class="highlight-box">
                <h3>10+</h3>
                <span>Years Experience</span>
            </div>
            <div class="highlight-box">
                <h3>100%</h3>
                <span>Satisfaction</span>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    <div class="footer-content">
        <h3>🎉 SMF.SEEFA – Event Management</h3>
        <p>Creating unforgettable moments for every special occasion ✨</p>
        <p>
            📧 <strong>Email:</strong> eventifySL1@gmail.com <br>
            📞 <strong>Phone:</strong> +94 77 123 4567
        </p>
        <div class="social-icons">
            <a href="#" aria-label="Facebook">📘</a>
            <a href="#" aria-label="Instagram">📸</a>
            <a href="#" aria-label="Twitter">🐦</a>
        </div>
        <p class="footer-copy">© 2025 SMF.SEEFA. All Rights Reserved 💼</p>
    </div>
</footer>

<script src="script.js"></script>
</body>
</html>
