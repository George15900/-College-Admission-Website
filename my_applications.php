<?php 
include '../config.php';

if (!isLoggedIn() || !checkUserType('student')) {
    redirect('../login.php');
}

// Get student info
$student_info = $conn->query("SELECT s.* FROM students s JOIN users u ON s.user_id = u.id WHERE u.id = {$_SESSION['user_id']}")->fetch_assoc();
$student_id = $student_info['id'];

// Get all applications
$applications = $conn->query("
    SELECT a.*, c.course_name, c.duration, c.fees, col.college_name, col.phone, col.address
    FROM applications a
    JOIN courses c ON a.course_id = c.id
    JOIN colleges col ON a.college_id = col.id
    WHERE a.student_id = $student_id
    ORDER BY a.application_date DESC
");

// Get statistics by status
$pending = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'pending'")->fetch_assoc()['count'];
$accepted = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'accepted'")->fetch_assoc()['count'];
$rejected = $conn->query("SELECT COUNT(*) as count FROM applications WHERE student_id = $student_id AND status = 'rejected'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
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
        <h1>My Applications</h1>

        <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); max-width: 900px;">
            <div class="stat-card stat-pending">
                <h3>Pending</h3>
                <p class="stat-number"><?php echo $pending; ?></p>
            </div>
            <div class="stat-card stat-success">
                <h3>Accepted</h3>
                <p class="stat-number"><?php echo $accepted; ?></p>
            </div>
            <div class="stat-card stat-danger">
                <h3>Rejected</h3>
                <p class="stat-number"><?php echo $rejected; ?></p>
            </div>
        </div>

        <h2>All Applications</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>College</th>
                        <th>Course</th>
                        <th>Duration</th>
                        <th>Fees</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Response Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($applications->num_rows > 0): ?>
                        <?php while ($app = $applications->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $app['college_name']; ?></strong><br>
                                    <small style="color: #718096;"><?php echo $app['phone']; ?></small>
                                </td>
                                <td><?php echo $app['course_name']; ?></td>
                                <td><?php echo $app['duration']; ?></td>
                                <td>₹<?php echo number_format($app['fees'], 2); ?></td>
                                <td><?php echo date('M d, Y', strtotime($app['application_date'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $app['status']; ?>">
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    if ($app['response_date']) {
                                        echo date('M d, Y', strtotime($app['response_date']));
                                    } else {
                                        echo '<span style="color: #a0aec0;">Awaiting Response</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                No applications yet. <a href="browse_courses.php">Start applying</a> to courses!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($accepted > 0): ?>
            <div style="background: #c6f6d5; padding: 1.5rem; border-radius: 10px; margin-top: 2rem;">
                <h3 style="color: #22543d; margin-bottom: 0.5rem;">🎉 Congratulations!</h3>
                <p style="color: #22543d;">You have <?php echo $accepted; ?> accepted application(s). Please contact the respective colleges for further admission procedures.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>