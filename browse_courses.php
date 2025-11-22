<?php 
include '../config.php';

if (!isLoggedIn() || !checkUserType('student')) {
    redirect('../login.php');
}

// Get student info
$student_info = $conn->query("SELECT s.* FROM students s JOIN users u ON s.user_id = u.id WHERE u.id = {$_SESSION['user_id']}")->fetch_assoc();
$student_id = $student_info['id'];

// Handle course application
if (isset($_POST['apply_course'])) {
    $course_id = $_POST['course_id'];
    $college_id = $_POST['college_id'];
    
    // Check if already applied
    $check = $conn->query("SELECT * FROM applications WHERE student_id = $student_id AND course_id = $course_id");
    
    if ($check->num_rows > 0) {
        $error = 'You have already applied for this course!';
    } else {
        $sql = "INSERT INTO applications (student_id, course_id, college_id) VALUES ($student_id, $course_id, $college_id)";
        if ($conn->query($sql)) {
            $success = 'Application submitted successfully!';
        } else {
            $error = 'Failed to submit application!';
        }
    }
}

// Get all courses from verified colleges
$courses = $conn->query("
    SELECT c.*, col.college_name, col.phone, col.address,
    (SELECT COUNT(*) FROM applications WHERE student_id = $student_id AND course_id = c.id) as already_applied
    FROM courses c
    JOIN colleges col ON c.college_id = col.id
    WHERE col.status = 'verified'
    ORDER BY c.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">Student Portal</div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="browse_courses.php">Browse Courses</a></li>
                <li><a href="my_applications.php">My Applications</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <h1>Available Courses</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="courses-grid">
            <?php if ($courses->num_rows > 0): ?>
                <?php while ($course = $courses->fetch_assoc()): ?>
                    <div class="course-card">
                        <div class="course-header">
                            <h3><?php echo $course['course_name']; ?></h3>
                            <span class="college-badge"><?php echo $course['college_name']; ?></span>
                        </div>
                        
                        <div class="course-details">
                            <p><strong>Duration:</strong> <?php echo $course['duration']; ?></p>
                            <p><strong>Fees:</strong> ₹<?php echo number_format($course['fees'], 2); ?></p>
                            <p><strong>Seats Available:</strong> <?php echo $course['seats_available']; ?></p>
                            <p class="course-description"><?php echo $course['description']; ?></p>
                        </div>
                        
                        <div class="course-footer">
                            <?php if ($course['already_applied'] > 0): ?>
                                <button class="btn btn-sm btn-secondary" disabled>Already Applied</button>
                            <?php else: ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <input type="hidden" name="college_id" value="<?php echo $course['college_id']; ?>">
                                    <button type="submit" name="apply_course" class="btn btn-sm btn-primary">Apply Now</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No courses available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>