<?php 
include '../config.php';

if (!isLoggedIn() || !checkUserType('college')) {
    redirect('../login.php');
}

// Get college info
$college_info = $conn->query("SELECT c.* FROM colleges c JOIN users u ON c.user_id = u.id WHERE u.id = {$_SESSION['user_id']}")->fetch_assoc();
$college_id = $college_info['id'];

// Get accepted students
$accepted = $conn->query("
    SELECT a.*, s.full_name, s.phone, s.address, s.dob, s.gender, c.course_name, u.email
    FROM applications a
    JOIN students s ON a.student_id = s.id
    JOIN users u ON s.user_id = u.id
    JOIN courses c ON a.course_id = c.id
    WHERE a.college_id = $college_id AND a.status = 'accepted'
    ORDER BY a.response_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Students</title>
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
        <h1>Accepted Students</h1>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Accepted On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($accepted->num_rows > 0): ?>
                        <?php while ($student = $accepted->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $student['full_name']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                                <td><?php echo $student['phone']; ?></td>
                                <td><?php echo $student['course_name']; ?></td>
                                <td><?php echo ucfirst($student['gender'] ?? 'N/A'); ?></td>
                                <td><?php echo $student['dob'] ? date('M d, Y', strtotime($student['dob'])) : 'N/A'; ?></td>
                                <td><?php echo date('M d, Y', strtotime($student['response_date'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No accepted students yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>