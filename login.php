<?php 
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = ($_POST['password']);
    if($email=='admin@gmail.com' &&  $password=='password1')
    {
       header("location:admin/dashboard.php"); 
    }
    $sql = "SELECT * FROM users WHERE email = '$email'and password='$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($password == $user['password']){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect based on user type
            switch ($user['user_type']) {
                case 'admin':
                    redirect('admin/dashboard.php');
                    break;
                case 'college':
                    redirect('colleges/dashboard.php');
                    break;
                case 'student':
                    redirect('student/dashboard.php');
                    break;
            }
        } else {
            $error = 'Invalid password!';
        }
    } else {
        $error = 'Email not found!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - College Portal</title>
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
            <h2>Login</h2>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form><br>
            
            <p class="text-center">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>