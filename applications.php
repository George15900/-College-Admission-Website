<?php 
include '../config.php';

if (!isLoggedIn() || !checkUserType('college')) {
    redirect('../login.php');
}

// Get college info
$college_info = $conn->query("SELECT c.* FROM colleges c JOIN users u ON c.user_id = u.id WHERE u.id = {$_SESSION['user_id']}")->fetch_assoc();
$college_id = $college_info['id'];

// Get all applications
$applications = $conn->query("
    SELECT a.*, s.full_name, s.phone, s.address, 
           c.course_name, u.email AS student_email
    FROM applications a
    JOIN students s ON a.student_id = s.id
    JOIN users u ON s.user_id = u.id
    JOIN courses c ON a.course_id = c.id
    WHERE a.college_id = $college_id
    ORDER BY 
        CASE a.status
            WHEN 'pending' THEN 1
            WHEN 'accepted' THEN 2
            WHEN 'rejected' THEN 3
        END,
        a.application_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Applications</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><?php echo $college_info['college_name']; ?></div>
            <ul class="nav-links">
         <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="courses.php">My Courses</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="accepted_students.php">Accepted Students</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <h1>All Applications</h1>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Response Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($applications && $applications->num_rows > 0): ?>
                        <?php while ($app = $applications->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($app['full_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($app['student_email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($app['phone'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($app['course_name'] ?? 'N/A'); ?></td>
                                <td><?php echo !empty($app['application_date']) ? htmlspecialchars(date('M d, Y', strtotime($app['application_date']))) : 'N/A'; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo htmlspecialchars($app['status'] ?? 'unknown'); ?>">
                                        <?php echo htmlspecialchars(ucfirst($app['status'] ?? 'unknown')); ?>
                                    </span>
                                </td>
                                <td><?php echo !empty($app['response_date']) ? htmlspecialchars(date('M d, Y', strtotime($app['response_date']))) : '-'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No applications received yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>