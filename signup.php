<?php 
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $conn->real_escape_string($_POST['user_type']);
    
    // Check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $error = 'Email already registered!';
    } else {
        // Insert user
        $sql = "INSERT INTO users (email, password, user_type) VALUES ('$email', '$password', '$user_type')";
        
        if ($conn->query($sql)) {
            $user_id = $conn->insert_id;
            
            // Insert into respective table based on user type
            if ($user_type == 'student') {
                $name = $conn->real_escape_string($_POST['full_name']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $conn->query("INSERT INTO students (user_id, full_name, phone) VALUES ($user_id, '$name', '$phone')");
            } elseif ($user_type == 'college') {
                $college_name = $conn->real_escape_string($_POST['college_name']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $address = $conn->real_escape_string($_POST['address']);
                $conn->query("INSERT INTO colleges (user_id, college_name, phone, address) VALUES ($user_id, '$college_name', '$phone', '$address')");
            }
            
            $success = 'Registration successful! Please login.';
        } else {
            $error = 'Registration failed!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - College Portal</title>
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

    <div class="form-container">
        <div class="form-box">
            <h2>Sign Up</h2>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" id="signupForm">
                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type" id="userType" required onchange="toggleFields()">
                        <option value="">Select Type</option>
                        <option value="student">Student</option>
                        <option value="college">College</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                
                <div id="studentFields" style="display:none;">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" id="full_name">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" id="student_phone">
                    </div>
                </div>
                
                <div id="collegeFields" style="display:none;">
                    <div class="form-group">
                        <label>College Name</label>
                        <input type="text" name="college_name" id="college_name">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" id="college_phone">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" id="address" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
            
            <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script>
        function toggleFields() {
            const userType = document.getElementById('userType').value;
            const studentFields = document.getElementById('studentFields');
            const collegeFields = document.getElementById('collegeFields');
            
            studentFields.style.display = 'none';
            collegeFields.style.display = 'none';
            
            if (userType === 'student') {
                studentFields.style.display = 'block';
                document.getElementById('full_name').required = true;
                document.getElementById('student_phone').required = true;
                document.getElementById('college_name').required = false;
                document.getElementById('college_phone').required = false;
            } else if (userType === 'college') {
                collegeFields.style.display = 'block';
                document.getElementById('college_name').required = true;
                document.getElementById('college_phone').required = true;
                document.getElementById('full_name').required = false;
                document.getElementById('student_phone').required = false;
            }
        }
    </script>
</body>
</html>