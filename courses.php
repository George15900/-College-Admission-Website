<?php 
include '../config.php';
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Provide safe fallbacks if helper functions aren't defined
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return !empty($_SESSION['user_id']);
    }
}
if (!function_exists('checkUserType')) {
    function checkUserType($type) {
        return (isset($_SESSION['user_type']) && $_SESSION['user_type'] === $type);
    }
}
if (!function_exists('redirect')) {
    function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}

// Access control
if (!isLoggedIn() || !checkUserType('college')) {
    redirect('../login.php');
}

// Ensure $conn exists
if (!isset($conn)) {
    die('Database connection not found. Please check config.php');
}

$user_id = intval($_SESSION['user_id'] ?? 0);
if ($user_id <= 0) {
    redirect('../login.php');
}

// Helper containers
$college_info = null;
$courses_data = [];
$success = null;
$error = null;

// Fetch college info safely
$sql_college = "SELECT c.* FROM colleges c JOIN users u ON c.user_id = u.id WHERE u.id = ? LIMIT 1";
try {
    if ($conn instanceof mysqli) {
        $stmt = $conn->prepare($sql_college);
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $college_info = $res->fetch_assoc() ?: null;
            $stmt->close();
        } else {
            error_log('Prepare error (colleges/courses.php): ' . $conn->error);
            $error = 'Unable to fetch college info.';
        }
    } elseif ($conn instanceof PDO) {
        $stmt = $conn->prepare($sql_college);
        if ($stmt->execute([$user_id])) {
            $college_info = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } else {
            error_log('PDO query failed (colleges/courses.php)');
            $error = 'Unable to fetch college info.';
        }
    } else {
        error_log('Unsupported DB connection type in colleges/courses.php');
        $error = 'Server configuration error.';
    }
} catch (Exception $e) {
    error_log('Exception (colleges/courses.php): ' . $e->getMessage());
    $error = 'Exception occurred while fetching college info.';
}

if (!$college_info) {
    // If college not found, stop with message
    die('College information not found or access denied.');
}

$college_id = intval($college_info['id']);

// Handle course addition (only if college verified)
if (isset($_POST['add_course']) && ($college_info['status'] ?? '') === 'verified') {
    $course_name = trim($_POST['course_name'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $fees = floatval($_POST['fees'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $seats = intval($_POST['seats_available'] ?? 0);

    $sql_insert = "INSERT INTO courses (college_id, course_name, duration, fees, description, seats_available) VALUES (?, ?, ?, ?, ?, ?)";

    try {
        if ($conn instanceof mysqli) {
            $stmt = $conn->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param('issdsi', $college_id, $course_name, $duration, $fees, $description, $seats);
                if ($stmt->execute()) {
                    $success = 'Course added successfully!';
                } else {
                    error_log('Insert error (colleges/courses.php): ' . $stmt->error);
                    $error = 'Failed to add course.';
                }
                $stmt->close();
            } else {
                error_log('Prepare error on insert (colleges/courses.php): ' . $conn->error);
                $error = 'Failed to prepare insert.';
            }
        } elseif ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql_insert);
            if ($stmt->execute([$college_id, $course_name, $duration, $fees, $description, $seats])) {
                $success = 'Course added successfully!';
            } else {
                $err = $stmt->errorInfo();
                error_log('PDO insert error (colleges/courses.php): ' . json_encode($err));
                $error = 'Failed to add course.';
            }
        }
    } catch (Exception $e) {
        error_log('Exception during insert (colleges/courses.php): ' . $e->getMessage());
        $error = 'Exception while adding course.';
    }
}

// Handle course deletion
if (isset($_GET['delete'])) {
    $course_id = intval($_GET['delete']);
    $sql_delete = "DELETE FROM courses WHERE id = ? AND college_id = ?";

    try {
        if ($conn instanceof mysqli) {
            $stmt = $conn->prepare($sql_delete);
            if ($stmt) {
                $stmt->bind_param('ii', $course_id, $college_id);
                if ($stmt->execute()) {
                    $success = 'Course deleted successfully!';
                } else {
                    error_log('Delete error (colleges/courses.php): ' . $stmt->error);
                    $error = 'Failed to delete course.';
                }
                $stmt->close();
            } else {
                error_log('Prepare error on delete (colleges/courses.php): ' . $conn->error);
                $error = 'Failed to prepare delete.';
            }
        } elseif ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql_delete);
            if ($stmt->execute([$course_id, $college_id])) {
                $success = 'Course deleted successfully!';
            } else {
                $err = $stmt->errorInfo();
                error_log('PDO delete error (colleges/courses.php): ' . json_encode($err));
                $error = 'Failed to delete course.';
            }
        }
    } catch (Exception $e) {
        error_log('Exception during delete (colleges/courses.php): ' . $e->getMessage());
        $error = 'Exception while deleting course.';
    }
}

// Fetch all courses for this college
$sql_courses = "SELECT * FROM courses WHERE college_id = ? ORDER BY created_at DESC";
try {
    if ($conn instanceof mysqli) {
        $stmt = $conn->prepare($sql_courses);
        if ($stmt) {
            $stmt->bind_param('i', $college_id);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $courses_data[] = $row;
            }
            $stmt->close();
        } else {
            error_log('Prepare error fetching courses (colleges/courses.php): ' . $conn->error);
        }
    } elseif ($conn instanceof PDO) {
        $stmt = $conn->prepare($sql_courses);
        if ($stmt->execute([$college_id])) {
            $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } else {
            error_log('PDO fetch courses error (colleges/courses.php)');
        }
    }
} catch (Exception $e) {
    error_log('Exception fetching courses (colleges/courses.php): ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><?php echo htmlspecialchars($college_info['college_name'] ?? 'College'); ?></div>
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
        <h1>Manage Courses</h1>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (($college_info['status'] ?? '') == 'verified'): ?>
            <div class="form-box">
                <h2>Add New Course</h2>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text" name="course_name" required>
                        </div>
                        <div class="form-group">
                            <label>Duration</label>
                            <input type="text" name="duration" placeholder="e.g., 4 Years" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Fees (₹)</label>
                            <input type="number" name="fees" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Seats Available</label>
                            <input type="number" name="seats_available" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                You can only add courses after your college is verified by admin.
            </div>
        <?php endif; ?>

        <h2>Your Courses</h2>
        <div class="courses-grid">
            <?php if (count($courses_data) > 0): ?>
                <?php foreach ($courses_data as $course): ?>
                    <div class="course-card">
                        <h3><?php echo htmlspecialchars($course['course_name'] ?? 'N/A'); ?></h3>
                        <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration'] ?? 'N/A'); ?></p>
                        <p><strong>Fees:</strong> ₹<?php echo number_format(floatval($course['fees'] ?? 0), 2); ?></p>
                        <p><strong>Seats:</strong> <?php echo htmlspecialchars($course['seats_available'] ?? '0'); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($course['description'] ?? '')); ?></p>
                        <a href="?delete=<?php echo intval($course['id']); ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this course?')">
                            Delete Course
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No courses added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>