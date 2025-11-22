<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Admission Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">College Portal</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="colleges.php">Colleges</a></li>
               
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to College Admission Portal</h1>
            <p>Your gateway to quality education</p>
            <div class="cta-buttons">
                <a href="colleges.php" class="btn btn-primary">Browse Colleges</a>
                <?php if (!isLoggedIn()): ?>
                    <a href="signup.php" class="btn btn-secondary">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Why Choose Us?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>🎓 Multiple Colleges</h3>
                    <p>Access to verified colleges offering various courses</p>
                </div>
                <div class="feature-card">
                    <h3>📝 Easy Application</h3>
                    <p>Simple and streamlined application process</p>
                </div>
                <div class="feature-card">
                    <h3>⚡ Quick Response</h3>
                    <p>Get admission decisions quickly</p>
                </div>
                <div class="feature-card">
                    <h3>📊 Track Status</h3>
                    <p>Monitor your application status in real-time</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 College Admission Portal. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>