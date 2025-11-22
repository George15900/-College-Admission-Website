<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Student Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 2rem;
            color: #2d3748;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 2rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #667eea;
            border: 4px solid white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .profile-info h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .profile-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: inline-block;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card.pending { border-top: 4px solid #ed8936; }
        .stat-card.accepted { border-top: 4px solid #48bb78; }
        .stat-card.rejected { border-top: 4px solid #f56565; }
        .stat-card.total { border-top: 4px solid #667eea; }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2d3748;
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
        }

        /* Profile Form */
        .profile-section {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.3rem;
            color: #2d3748;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4a5568;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .form-group input:disabled {
            background: #f7fafc;
            color: #718096;
        }

        /* Buttons */
        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
            font-size: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #4a5568;
        }

        .btn-success {
            background-color: #48bb78;
            color: white;
        }

        .btn-danger {
            background-color: #f56565;
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            display: none;
        }

        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #48bb78;
        }

        .alert-error {
            background-color: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #f56565;
        }

        .alert.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Account Settings */
        .settings-list {
            list-style: none;
        }

        .settings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-info h4 {
            color: #2d3748;
            margin-bottom: 0.3rem;
        }

        .settings-info p {
            color: #718096;
            font-size: 0.9rem;
        }

        /* Toggle Switch */
        .toggle {
            position: relative;
            width: 50px;
            height: 26px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 26px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #667eea;
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                gap: 1rem;
                font-size: 0.85rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
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
        <!-- Alert Messages -->
        <div class="alert alert-success" id="successAlert">
            ✓ Profile updated successfully!
        </div>
        <div class="alert alert-error" id="errorAlert">
            ✗ Please fill in all required fields!
        </div>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="avatar" id="avatarInitials">GV</div>
            <div class="profile-info">
                <h2 id="displayName">George vincent</h2>
                <p id="displayEmail">Georgevincen15@email.com</p>
                <span class="profile-badge">🎓 Student Account</span>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card total">
                <div class="stat-number">2</div>
                <div class="stat-label">Total Applications</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-number">1</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card accepted">
                <div class="stat-number">1</div>
                <div class="stat-label">Accepted</div>
            </div>
            <div class="stat-card rejected">
                <div class="stat-number">0</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="profile-section">
            <h3 class="section-title">📋 Personal Information</h3>
            <form id="profileForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" id="fullName" value="George Vincent" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="email" value="Georgevincen15@email.com" disabled>
                    </div>
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="tel" id="phone" value="+91 98765 43210" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" id="dob" value="2005-03-15">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" id="city" value="Mumbai">
                    </div>
                    <div class="form-group full-width">
                        <label>Full Address</label>
                        <textarea id="address" rows="3">123 Main Street, Andheri West, Mumbai, Maharashtra - 400053</textarea>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">↩ Reset</button>
                </div>
            </form>
        </div>

        <!-- Education Details -->
        <div class="profile-section">
            <h3 class="section-title">🎓 Education Details</h3>
            <form id="educationForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Highest Qualification</label>
                        <select id="qualification">
                            <option value="">Select Qualification</option>
                            <option value="10th">10th Standard</option>
                            <option value="12th" selected>12th Standard</option>
                            <option value="graduation">Graduation</option>
                            <option value="postgraduation">Post Graduation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Passing Year</label>
                        <input type="number" id="passingYear" value="2023" min="2000" max="2025">
                    </div>
                    <div class="form-group">
                        <label>Board/University</label>
                        <input type="text" id="board" value="CBSE">
                    </div>
                    <div class="form-group">
                        <label>Percentage/CGPA</label>
                        <input type="text" id="percentage" value="85.5%">
                    </div>
                    <div class="form-group full-width">
                        <label>School/College Name</label>
                        <input type="text" id="schoolName" value="St. Xavier's High School, Mumbai">
                    </div>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">💾 Save Education</button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="profile-section">
            <h3 class="section-title">🔐 Change Password</h3>
            <form id="passwordForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" id="currentPassword" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" id="newPassword" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" id="confirmPassword" placeholder="Confirm new password">
                    </div>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">🔒 Update Password</button>
                </div>
            </form>
        </div>

        <!-- Account Settings -->
        <div class="profile-section">
            <h3 class="section-title">⚙️ Account Settings</h3>
            <ul class="settings-list">
                <li class="settings-item">
                    <div class="settings-info">
                        <h4>Email Notifications</h4>
                        <p>Receive email updates about your applications</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="emailNotif" checked>
                        <span class="slider"></span>
                    </label>
                </li>
                <li class="settings-item">
                    <div class="settings-info">
                        <h4>SMS Notifications</h4>
                        <p>Receive SMS alerts for important updates</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="smsNotif">
                        <span class="slider"></span>
                    </label>
                </li>
                <li class="settings-item">
                    <div class="settings-info">
                        <h4>Profile Visibility</h4>
                        <p>Allow colleges to view your profile</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="profileVisibility" checked>
                        <span class="slider"></span>
                    </label>
                </li>
                <li class="settings-item">
                    <div class="settings-info">
                        <h4>Delete Account</h4>
                        <p>Permanently delete your account and data</p>
                    </div>
                    <button class="btn btn-danger" onclick="deleteAccount()">Delete Account</button>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Store original data
        const originalData = {
            fullName: 'John Doe',
            phone: '+91 98765 43210',
            dob: '2000-05-15',
            gender: 'male',
            city: 'Mumbai',
            address: '123 Main Street, Andheri West, Mumbai, Maharashtra - 400053'
        };

        // Profile Form Submit
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fullName = document.getElementById('fullName').value;
            const phone = document.getElementById('phone').value;

            if (!fullName || !phone) {
                showAlert('error');
                return;
            }

            // Update header
            document.getElementById('displayName').textContent = fullName;
            document.getElementById('avatarInitials').textContent = getInitials(fullName);
            
            showAlert('success');
        });

        // Education Form Submit
        document.getElementById('educationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showAlert('success');
        });

        // Password Form Submit
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const current = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;

            if (!current || !newPass || !confirm) {
                showAlert('error');
                return;
            }

            if (newPass !== confirm) {
                alert('New passwords do not match!');
                return;
            }

            if (newPass.length < 6) {
                alert('Password must be at least 6 characters!');
                return;
            }

            // Clear password fields
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
            
            showAlert('success');
            alert('Password updated successfully!');
        });

        // Get initials from name
        function getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        }

        // Show alert
        function showAlert(type) {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            successAlert.classList.remove('show');
            errorAlert.classList.remove('show');

            if (type === 'success') {
                successAlert.classList.add('show');
            } else {
                errorAlert.classList.add('show');
            }

            // Auto hide after 3 seconds
            setTimeout(() => {
                successAlert.classList.remove('show');
                errorAlert.classList.remove('show');
            }, 3000);
        }

        // Reset form
        function resetForm() {
            document.getElementById('fullName').value = originalData.fullName;
            document.getElementById('phone').value = originalData.phone;
            document.getElementById('dob').value = originalData.dob;
            document.getElementById('gender').value = originalData.gender;
            document.getElementById('city').value = originalData.city;
            document.getElementById('address').value = originalData.address;
            
            document.getElementById('displayName').textContent = originalData.fullName;
            document.getElementById('avatarInitials').textContent = getInitials(originalData.fullName);
            
            alert('Form reset to original values!');
        }

        // Delete account
        function deleteAccount() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone!')) {
                if (confirm('This will permanently delete all your data including applications. Continue?')) {
                    alert('Account deletion request submitted. You would be logged out in a real application.');
                }
            }
        }

        // Toggle event listeners
        document.querySelectorAll('.toggle input').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const settingName = this.closest('.settings-item').querySelector('h4').textContent;
                const status = this.checked ? 'enabled' : 'disabled';
                console.log(`${settingName}: ${status}`);
            });
        });
    </script>
</body>
</html>