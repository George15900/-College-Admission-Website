<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges - College Portal</title>
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

        /* Main Content */
        .main-content {
            padding: 3rem 0;
            min-height: 70vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 1rem;
            color: #2d3748;
            font-size: 2.5rem;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 3rem;
        }

        /* Search and Filter */
        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-box {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-box input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-box select {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        /* Colleges Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .course-header {
            margin-bottom: 1rem;
        }

        .course-header h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-verified {
            background: #c6f6d5;
            color: #22543d;
        }

        .course-details {
            margin: 1rem 0;
            color: #4a5568;
        }

        .course-details p {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
        }

        .course-details strong {
            min-width: 120px;
        }

        .course-description {
            color: #718096;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-top: 1rem;
        }

        .course-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 0.7rem 1.3rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
            font-size: 0.95rem;
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

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            background: #2d3748;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
            color: #718096;
        }

        /* Stats Bar */
        .stats-bar {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            .courses-grid {
                grid-template-columns: 1fr;
            }

            .search-box {
                flex-direction: column;
            }

            .stats-bar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
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

    <div class="main-content">
        <div class="container">
            <h1>Verified Colleges</h1>
            <p class="subtitle">Browse through our verified colleges and explore their course offerings</p>

            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-number" id="totalColleges">0</div>
                    <div class="stat-label">Total Colleges</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="totalCourses">0</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="totalStudents">0</div>
                    <div class="stat-label">Active Students</div>
                </div>
            </div>

            <div class="search-section">
                <div class="search-box">
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="🔍 Search colleges by name, location..."
                    >
                    <select id="locationFilter">
                        <option value="">All Locations</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Bangalore">Bangalore</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Pune">Pune</option>
                    </select>
                </div>
            </div>

            <div class="courses-grid" id="collegesGrid">
                <!-- Colleges will be loaded here -->
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 College Admission Portal. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Sample college data
        const colleges = [
            {
                id: 1,
                name: "Tech University Mumbai",
                address: "Andheri East, Mumbai, Maharashtra",
                phone: "+91 22 1234 5678",
                courses: 15,
                description: "Premier institution offering undergraduate and postgraduate programs in Engineering, Computer Science, and Technology with state-of-the-art infrastructure.",
                location: "Mumbai"
            },
            {
                id: 2,
                name: "Delhi College of Arts & Science",
                address: "Connaught Place, New Delhi",
                phone: "+91 11 9876 5432",
                courses: 22,
                description: "Renowned college specializing in Arts, Commerce, and Science streams with experienced faculty and excellent placement records.",
                location: "Delhi"
            },
            {
                id: 3,
                name: "Bangalore Institute of Management",
                address: "Koramangala, Bangalore, Karnataka",
                phone: "+91 80 5555 6666",
                courses: 18,
                description: "Leading business school offering MBA, BBA, and executive education programs with strong industry connections.",
                location: "Bangalore"
            },
            {
                id: 4,
                name: "Chennai Medical College",
                address: "T. Nagar, Chennai, Tamil Nadu",
                phone: "+91 44 7777 8888",
                courses: 12,
                description: "Prestigious medical institution with MBBS, BDS, and nursing programs, equipped with modern hospital facilities.",
                location: "Chennai"
            },
            {
                id: 5,
                name: "Pune Engineering Academy",
                address: "Shivaji Nagar, Pune, Maharashtra",
                phone: "+91 20 3333 4444",
                courses: 20,
                description: "Top-rated engineering college offering programs in Mechanical, Civil, Computer Science, and Electronics with research facilities.",
                location: "Pune"
            },
            {
                id: 6,
                name: "Mumbai Law School",
                address: "Fort, Mumbai, Maharashtra",
                phone: "+91 22 6666 7777",
                courses: 8,
                description: "Distinguished law college offering LLB, LLM programs with moot court and internship opportunities at leading law firms.",
                location: "Mumbai"
            },
            {
                id: 7,
                name: "Delhi Institute of Fashion",
                address: "Hauz Khas, New Delhi",
                phone: "+91 11 4444 5555",
                courses: 10,
                description: "Creative hub for fashion design, textile design, and fashion management with industry collaborations and fashion shows.",
                location: "Delhi"
            },
            {
                id: 8,
                name: "Bangalore School of Architecture",
                address: "Indiranagar, Bangalore, Karnataka",
                phone: "+91 80 2222 3333",
                courses: 6,
                description: "Specialized college for architecture and urban planning with design studios and practical project experience.",
                location: "Bangalore"
            }
        ];

        // Initialize page
        function init() {
            displayColleges(colleges);
            updateStats();
            setupEventListeners();
        }

        // Display colleges
        function displayColleges(collegesToDisplay) {
            const grid = document.getElementById('collegesGrid');
            
            if (collegesToDisplay.length === 0) {
                grid.innerHTML = `
                    <div class="no-results" style="grid-column: 1/-1;">
                        <h3>No colleges found</h3>
                        <p>Try adjusting your search filters</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = collegesToDisplay.map(college => `
                <div class="course-card" data-location="${college.location}">
                    <div class="course-header">
                        <h3>${college.name}</h3>
                        <span class="badge badge-verified">✓ Verified</span>
                    </div>
                    
                    <div class="course-details">
                        <p><strong>📍 Address:</strong> ${college.address}</p>
                        <p><strong>📞 Phone:</strong> ${college.phone}</p>
                        <p><strong>📚 Courses:</strong> ${college.courses} available</p>
                        <p class="course-description">${college.description}</p>
                    </div>
                    
                    <div class="course-footer">
                        <button class="btn btn-primary btn-sm" onclick="viewCourses(${college.id})">
                            View Courses
                        </button>
                        <button class="btn btn-secondary btn-sm" onclick="viewDetails(${college.id})">
                            More Info
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Update statistics
        function updateStats() {
            document.getElementById('totalColleges').textContent = colleges.length;
            document.getElementById('totalCourses').textContent = colleges.reduce((sum, c) => sum + c.courses, 0);
            document.getElementById('totalStudents').textContent = '2,547';
            
            // Animate numbers
            animateNumber('totalColleges', colleges.length);
            animateNumber('totalCourses', colleges.reduce((sum, c) => sum + c.courses, 0));
        }

        // Animate numbers
        function animateNumber(id, target) {
            const element = document.getElementById(id);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 20);
        }

        // Setup event listeners
        function setupEventListeners() {
            const searchInput = document.getElementById('searchInput');
            const locationFilter = document.getElementById('locationFilter');

            searchInput.addEventListener('input', filterColleges);
            locationFilter.addEventListener('change', filterColleges);
        }

        // Filter colleges
        function filterColleges() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const location = document.getElementById('locationFilter').value;

            const filtered = colleges.filter(college => {
                const matchesSearch = 
                    college.name.toLowerCase().includes(searchTerm) ||
                    college.address.toLowerCase().includes(searchTerm) ||
                    college.description.toLowerCase().includes(searchTerm);
                
                const matchesLocation = !location || college.location === location;

                return matchesSearch && matchesLocation;
            });

            displayColleges(filtered);
        }

        // View courses
        function viewCourses(collegeId) {
            const college = colleges.find(c => c.id === collegeId);
            alert(`Viewing courses for ${college.name}\n\nThis would redirect to the course listing page for this college.\n\nNote: Login as a student to apply for courses.`);
        }

        // View details
        function viewDetails(collegeId) {
            const college = colleges.find(c => c.id === collegeId);
            alert(`College Details:\n\nName: ${college.name}\nLocation: ${college.address}\nPhone: ${college.phone}\nCourses: ${college.courses}\n\nDescription: ${college.description}`);
        }

        // Initialize on page load
        init();
    </script>
</body>
</html>