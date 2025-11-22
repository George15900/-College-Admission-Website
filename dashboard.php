<?php 
include '../config.php';

if (!isLoggedIn() || !checkUserType('student')) {
    redirect('../login.php');
}

// Get student info
$student_info = $conn->query("SELECT s.* FROM students s JOIN users u ON s.user_id = u.id WHERE u.id = {$_SESSION['user_id']}")->fetch_assoc();
$student_id = $student_info['id'];

// Get statistics
$total_applications = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id")->fetch_assoc()['count'];
$pending_applications = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'pending'")->fetch_assoc()['count'];
$accepted_applications = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'accepted'")->fetch_assoc()['count'];
$rejected_applications = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'rejected'")->fetch_assoc()['count'];

// Get recent applications
$applications = $conn->query("
    SELECT a.*, c.course_name, col.college_name
    FROM applications a
    JOIN courses c ON a.course_id = c.id
    JOIN colleges col ON a.college_id = col.id
    WHERE a.student_id = $student_id
    ORDER BY a.application_date DESC
    LIMIT 10
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
        <h1>Welcome, <?php echo $student_info['full_name']; ?>!</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Applications</h3>
                <p class="stat-number"><?php echo $total_applications; ?></p>
            </div>
            <div class="stat-card stat-pending">
                <h3>Pending</h3>
                <p class="stat-number"><?php echo $pending_applications; ?></p>
            </div>
            <div class="stat-card stat-success">
                <h3>Accepted</h3>
                <p class="stat-number"><?php echo $accepted_applications; ?></p>
            </div>
            <div class="stat-card stat-danger">
                <h3>Rejected</h3>
                <p class="stat-number"><?php echo $rejected_applications; ?></p>
            </div>
        </div>

        <h2>Recent Applications</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>College</th>
                        <th>Course</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Response Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($applications->num_rows > 0): ?>
                        <?php while ($app = $applications->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $app['college_name']; ?></td>
                                <td><?php echo $app['course_name']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($app['application_date'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $app['status']; ?>">
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo $app['response_date'] ? date('M d, Y', strtotime($app['response_date'])) : '-'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                No applications yet. <a href="browse_courses.php">Browse courses</a> to get started!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="cta-section">
            <h2>Ready to apply?</h2>
            <p>Browse available courses from verified colleges and start your educational journey!</p>
            <a href="browse_courses.php" class="btn btn-primary">Browse Courses</a>
        </div>
    </div>
</body>
</html>