<?php
session_name('user');
session_start();
$isLoggedIn = isset($_SESSION['username']); // Check if user session is set
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : '';

// Database connection
include 'insert.php'; // Ensure this file contains your database connection code

// Fetch upcoming events
$events = [];
$sql = "SELECT title, event_date, description FROM event";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    $events = []; // No events found
}
$sql_reviews = "SELECT username, feedback, rating FROM feedback";
$result_reviews = $conn->query($sql_reviews);

$reviews = [];
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
} else {
    echo "";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decoration Management System</title>
    <meta name="description" content="HM Decoration - Elegant event designs, services, and customer reviews.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Georgia';
            font-size: 15px;
            margin: 0;
            padding: 0;
            background-color:white; /* Very light blue for overall page */
        }

        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 10; /* Adjust z-index to ensure sidebar stays on top */
            top: 0;
            left: 0;
            background-color: #2c3e50; /* Darker background for a modern look */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5); /* Subtle shadow for depth */
            overflow-x: hidden;
            transition: width 0.4s ease; /* Smooth transition for width */
            padding-top: 60px;
        }

        .sidebar a {
            padding: 15px 30px; /* Increased padding for better touch targets */
            text-decoration: none;
            font-size: 18px; /* Slightly smaller font size for a cleaner look */
            color: #ecf0f1; /* Lighter text color for contrast */
            display: flex; /* Use flexbox for icon and text alignment */
            align-items: center; /* Center items vertically */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for background color and transform */
            border-radius: 5px; /* Rounded corners for links */
        }

        .sidebar a:hover {
            background-color: #34495e; /* Darker hover effect */
            color: #ffffff; /* White text on hover */
            transform: scale(1.05); /* Slightly enlarge the link on hover */
        }

        .sidebar a i {
            margin-right: 10px; /* Space between icon and text */
            transition: transform 0.3s ease; /* Smooth transition for icon */
        }

        .sidebar a:hover i {
            transform: translateY(-5px); /* Move the icon up slightly on hover */
        }

        /* Logout Link Styling */
        .logout-link {
            background-color: #e74c3c; /* Brighter red for logout link */
            color: white; /* Ensure text color is white for contrast */
            padding: 15px 30px; /* Match padding with other links */
            text-decoration: none; /* Remove underline */
            display: flex; /* Use flexbox for icon and text alignment */
            align-items: center; /* Center items vertically */
            transition: background-color 0.3s ease; /* Smooth transition */
            margin-top: auto; /* Push the logout link to the bottom */
        }

        .logout-link:hover {
            background-color: #c0392b; /* Darker red on hover */
        }

        /* Hamburger Icon */
        .hamburger {
            font-size: 35px;
            color: black;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 20;
            transition: left 0.3s, background 0.3s;
            border-radius: 5px;
            min-width: 120px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 12px;
            background: rgba(255,255,255,0.85);
            box-shadow: 0 2px 8px rgba(44,62,80,0.07);
        }

        .hamburger .menu-label {
            font-size: 20px;
            color: #333;
            margin-left: 12px;
            font-family: 'Georgia', serif;
            font-weight: 600;
            letter-spacing: 1px;
            transition: color 0.2s, opacity 0.3s;
            opacity: 1;
        }

        .hamburger.open .menu-label {
            opacity: 0; /* Hide "Menu" when sidebar is open/cross is shown */
            pointer-events: none;
        }

        /* Main Content Area */
        #main {
            transition: margin-left 0.3s ease;
            padding: 40px;
            margin-left: 60px;
        }

        #main.shifted {
            margin-left: 250px;
        }

        /* Header Styling */
        header {
            text-align: center;
            padding: 50px;
            background-color: #f7f7f7; /* Very light gray */
            margin-top: 40px;
            min-height: 200px; /* Set a minimum height for consistent spacing */
        }

        #t1 {
            font-size: 40px;
            color: #333;
        }

        .book-service-link {
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .book-service-link:hover {
            background-color: #218838;
        }

        /* Special Offers Section */
        .special-offer {
            text-align: center;
            margin: 50px auto;
            padding: 40px 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .special-offer h2 {
            font-size: 36px;
            color: #333;
        }

        .special-offer p {
            font-size: 18px;
            color: #555;
        }

        .special-offer-timer {
            font-size: 24px;
            color: #d9534f;
            margin: 20px 0;
        }

        /* Showcase Section Styling */
        .showcase {
            margin: 50px auto;
            padding: 20px;
            background-color: #fffbe6; /* Light yellow */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .showcase-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        /* Flip Card Styles */
        .flip-card {
            background-color: transparent;
            width: 300px; /* Adjust width as needed */
            height: 200px; /* Adjust height as needed */
            perspective: 1000px; /* Add perspective */
            margin: 20px; /* Space between cards */
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d; /* Preserve 3D effect */
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg); /* Rotate on hover */
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden; /* Hide back face */
        }

        .flip-card-front {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .flip-card-back {
            background-color: #2980b9; /* Back color */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transform: rotateY(180deg); /* Rotate back face */
            padding: 20px; /* Add padding for spacing */
            line-height: 1.5; /* Increase line height for better readability */
        }

        .upcoming-events {
            text-align: center;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #eaf6fb, #f8f9fa); /* Light blue gradient */
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            height: 400px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .upcoming-events h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 0;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .events-container {
            overflow: hidden; /* Hide scrollbar */
            height: 300px;
            position: relative;
            padding: 10px;
        }

        .upcoming-events ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
            animation: scrollEvents 10s linear infinite;
        }

        .upcoming-events li {
            font-size: 18px;
            color: #444;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .upcoming-events li:hover {
            transform: scale(1.05);
            background: #f0f0f0;
        }

        @keyframes scrollEvents {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-100%);
            } /* Scroll up */
        }

        /* Add glowing effect to the container */
        .upcoming-events::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.5);
            z-index: -1;
            border-radius: 12px;
        }

        .gallery img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            display: none; /* Hide images by default */
        }

        .gallery img.active {
            display: block; /* Show the active image */
        }

        /* Logo Hover Tooltip Styling */
        .logo-container {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 10;
        }

        .logo {
            margin-top: -10px;
            width: 220px;
            height: auto;
        }

        .tooltip {
            display: none;
            position: absolute;
            top: 100%; /* Appear just below the logo */
            right: 0;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            width: 200px;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0 , 0.3);
            z-index: 15;
        }

        .logo-container:hover .tooltip {
            display: block;
        }

        /* Adjustments for consistent spacing */
        #main {
            padding-top: 100px; /* Ensure there's space for the logo */
        }

        .welcome-message {
            font-size: 36px; /* Increased font size */
            margin-bottom: 20px; /* Space below the heading */
        }

        .greeting-message {
            font-size: 20px; /* Optional: Increase the size of the greeting message */
        }

        /* Review Section Styles */
        .review-container {
            margin: 20px auto; /* Center the review container */
            padding: 20px; /* Add padding around the container */
            background-color: #f8f9fa; /* Light gray */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            max-width: 800px; /* Limit the width of the review container */
            height: 300px; /* Fixed height for scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .review {
            background: #fff; /* White background for each review */
            padding: 15px; /* Padding inside each review */
            border-radius: 8px; /* Rounded corners for each review */
            margin-bottom: 15px; /* Space between reviews */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for each review */
        }

        .review h3 {
            margin: 0 0 10px; /* Space below the heading */
            font-size: 20px; /* Font size for the username and rating */
            color: #333; /* Dark color for the heading */
        }

        .review p {
            margin: 0; /* Remove default margin */
            font-size: 16px; /* Font size for the feedback */
            color: #555; /* Slightly lighter color for the feedback */
        }

        /* Center the title of the reviews section */
        h2.review-title {
            text-align: center; /* Center the title */
            font-size: 28px; /* Font size for the title */
            color: #333; /* Color for the title */
            margin-bottom: 20px; /* Space below the title */
        }

        /* Toast Notification Styles */
        .login-toast {
            position: fixed;
            top: 30px; /* changed from bottom to top */
            right: 30px;
            background: #000; /* changed to black */
            color: #fff;
            padding: 18px 32px 18px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            font-size: 18px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 16px;
            animation: fadeIn 0.7s;
        }

        .login-toast-close {
            font-size: 22px;
            cursor: pointer;
            margin-left: 10px;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }

        /* Centered Login Dialog Styles */
        .center-login-dialog {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .center-login-box {
            background: #fff;
            padding: 40px 32px 32px 32px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            text-align: center;
            min-width: 350px;
            max-width: 90vw;
            position: relative;
        }
        .center-login-close {
            position: absolute;
            top: 18px;
            right: 24px;
            font-size: 32px;
            color: #333;
            cursor: pointer;
            font-weight: bold;
        }
        .center-login-box h2 {
            font-size: 32px;
            margin-bottom: 18px;
            color: #222;
        }
        .center-login-box p {
            font-size: 20px;
            margin-bottom: 28px;
            color: #444;
        }
        .center-login-btn {
            display: inline-block;
            margin: 10px 18px 0 18px;
            padding: 14px 38px;
            background: #3498db;
            color: #fff;
            border-radius: 7px;
            font-size: 22px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .center-login-btn.signup {
            background: #28a745;
        }
        .center-login-btn:hover {
            background: #2980b9;
        }
        .center-login-btn.signup:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="#" onclick="closeNav()"><i class="fas fa-home"></i> Home</a>
        <a href="./package.php" onclick="closeNav()"><i class="fas fa-gift"></i> Services</a>
        <?php if ($isLoggedIn): ?>
            <a href="./about.php" onclick="closeNav()"><i class="fas fa-info-circle"></i> About Us</a>
            <a href="contact.php" onclick="closeNav()"><i class="fas fa-envelope"></i> Contact</a>
            <a href="./data.php" onclick="closeNav()"><i class="fas fa-list-alt"></i> Show Bookings</a>
            <a href="logout.php" class="logout-link" onclick="closeNav()"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
            <a href="login.php" onclick="closeNav()"><i class="fas fa-sign-in-alt"></i> Login</a>
        <?php endif; ?>
    </div>

    <!-- Hamburger Icon (Menu label removed) -->
    <div class="hamburger" onclick="toggleNav()" aria-label="Open navigation menu">
        <i id="navIcon" class="fas fa-bars"></i>
        <span class="menu-label">Menu</span>
    </div>

    <!-- Company Logo with Hover Info -->
    <div class="logo-container">
        <img src="./uploads/logo.png" alt="Company Logo" class="logo ">
        <div class="tooltip">
            <p>HM Decoration</p>
            <p>Creating Elegant Designs</p>
            <p>Contact: +91 6351709559</p>
            <p>Email: hmdecoration@gmail.com</p>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main">
        <h2 class="welcome-message">Welcome to HM Decoration</h2>
        <?php if ($isLoggedIn): ?>
            <p class="greeting-message">Hello, <?php echo $username; ?>!</p>
        <?php endif; ?>
    </div>

    <!-- Header Section -->
    <header>
        <h1 id="t1">Let us do the beauty designs,<br>that you never seen before.</h1>
        <div style="text-align: center; margin-top: 20px;">
            <a href="./package.php" class="book-service-link">SERVICES</a>
        </div>
    </header>

    <!-- Showcase Section -->
    <div class="showcase">
        <h2 style="text-align: center; margin: 40px 0; color: #333;">Our Beautiful Creations</h2>
        <div class="showcase-container">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./uploads/img1.png" alt="Showcase 1">
                        <div class="showcase-text">Elegant Wedding Stage Design</div>
                    </div>
                    <div class="flip-card-back">
                        <h3>Details</h3>
                        <p>Elegant wedding stage design with beautiful floral arrangements.</p>
                    </div>
                </div>
            </div>

            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./uploads/img2.jpeg" alt="Showcase 2">
                        <div class="showcase-text">Outdoor Event Setup with Lights</div>
                    </div>
                    <div class="flip-card-back">
                        <h3>Details</h3>
                        <p>Stunning outdoor setup with ambient lighting for a magical experience.</p>
                    </div>
                </div>
            </div>

            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./uploads/img3.png" alt="Showcase 3">
                        <div class="showcase-text">Birthday Party Theme Decoration</div>
                    </div>
                    <div class="flip-card-back">
                        <h3>Details</h3>
                        <p>Colorful decorations tailored for a memorable birthday celebration.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="upcoming-events">
        <h2>Upcoming Events</h2>
        <p>Join us for our exciting upcoming events!</p><br><br>
        <div class="events-container">
            <ul>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($event['title']); ?></strong><br>
                            <em><?php echo htmlspecialchars($event['event_date']); ?></em><br>
                            <?php echo htmlspecialchars($event['description']); ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No upcoming events available.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <h2 class="review-title">Customer Reviews</h2>

    <div class="review-container">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <h3><?php echo htmlspecialchars($review['username']); ?> - <?php echo $review['rating']; ?>/5</h3>
                    <p><?php echo htmlspecialchars($review['feedback']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-reviews">No reviews available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer style=" color: black; text-align: center; padding: 20px; margin-top: 40px;">
        <p>&copy; HM Decoration</p>
        <p>Developed by Het Modi</p>
    </footer>

    <!-- Centered Login Dialog (initially hidden) -->
    <?php if (!$isLoggedIn): ?>
    <div id="centerLoginDialog" class="center-login-dialog" style="display:none;">
        <div class="center-login-box">
            <span class="center-login-close" onclick="closeCenterLoginDialog()">&times;</span>
            <h2>Welcome!</h2>
            <p>For booking and more features,<br>please login or sign up.</p>
            <a href="login.php" class="center-login-btn">Login</a>
            <a href="registration.php" class="center-login-btn signup">Sign Up</a>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Sidebar Toggle Script
        let isOpen = localStorage.getItem('sidebarOpen') === 'true'; // Check localStorage for sidebar state

        function toggleNav() {
            if (isOpen) {
                closeNav();
            } else {
                openNav();
            }
            isOpen = !isOpen; // Toggle the state
            localStorage.setItem('sidebarOpen', isOpen); // Save the state to localStorage
        }

        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").classList.add("shifted");
            document.querySelector(".hamburger").classList.add("open");
            document.getElementById("navIcon").classList.remove("fa-bars");
            document.getElementById("navIcon").classList.add("fa-times");
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").classList.remove("shifted");
            document.querySelector(".hamburger").classList.remove("open");
            document.getElementById("navIcon").classList.remove("fa-times");
            document.getElementById("navIcon").classList.add("fa-bars");
        }

        // Set the initial state of the sidebar based on localStorage
        if (isOpen) {
            openNav(); // Open the sidebar if it was previously open
        }

        // Automatic Gallery Slider
        let currentIndex = 0;
        const images = document.querySelectorAll('.gallery img');
        const totalImages = images.length;

        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % totalImages; // Loop back to the first image
            images[currentIndex].classList.add('active');
        }

        setInterval(showNextImage, 2000); // Change image every 3 seconds

        // Centered Login Dialog Script
        function openCenterLoginDialog() {
            document.getElementById('centerLoginDialog').style.display = 'flex';
        }

        function closeCenterLoginDialog() {
            document.getElementById('centerLoginDialog').style.display = 'none';
        }

        // Auto-open the centered login dialog for demo (remove this in production)
        <?php if (!$isLoggedIn): ?>
            setTimeout(openCenterLoginDialog, 5000); // Auto-open after 5 seconds
        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('centerLoginDialogShown')) {
        setTimeout(function() {
            document.getElementById('centerLoginDialog').style.display = 'flex';
            localStorage.setItem('centerLoginDialogShown', 'true');
        }, 10000); // 10 seconds
    }
});
function closeCenterLoginDialog() {
    document.getElementById('centerLoginDialog').style.display = 'none';
}
<?php endif; ?>
    </script>
</body>


</html>