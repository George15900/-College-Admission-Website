<?php 
include 'config.php';

// Get all verified colleges with course count
$colleges = $conn->query("
    SELECT c.*, 
    (SELECT COUNT(*) FROM courses WHERE college_id = c.id) as course_count
    FROM colleges c
    WHERE c.status = 'verified'
    ORDER BY c.college_name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges - College Portal</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">College Portal</div>
            <ul class="nav-links">
             <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="colleges.php">Colleges</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="../logout.php">Logout</a></li>
             
            </ul>
        </div>
    </nav>

    <div style="padding: 3rem 0; min-height: 70vh;">
        <div class="container">
            <h1 style="text-align: center; margin-bottom: 3rem; color: #2d3748;">Verified Colleges</h1>

            <div class="courses-grid">
                <?php if ($colleges->num_rows > 0): ?>
                    <?php while ($college = $colleges->fetch_assoc()): ?>
                        <div class="course-card">
                            <div class="course-header">
                                <h3><?php echo $college['college_name']; ?></h3>
                                <span class="badge badge-verified">Verified</span>
                            </div>
                            
                            <div class="course-details">
                                <p><strong>📍 Address:</strong> <?php echo $college['address']; ?></p>
                                <p><strong>📞 Phone:</strong> <?php echo $college['phone']; ?></p>
                                <p><strong>📚 Courses Offered:</strong> <?php echo $college['course_count']; ?></p>
                                <?php if ($college['description']): ?>
                                    <p class="course-description"><?php echo $college['description']; ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="course-footer">
                                <?php if (isLoggedIn() && checkUserType('student')): ?>
                                    <a href="student/browse_courses.php" class="btn btn-sm btn-primary">View Courses</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-sm btn-secondary">Login to View Courses</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; width: 100%;">No verified colleges available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 College Admission Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>