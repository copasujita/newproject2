<div class="sidebar">
    <h2>Emp Portal</h2>
    <ul>
    <li><a href="view_messages.php">✉️ Messages from Admin</a></li>
        <li><a href="employee_dashboard.php">My Profile</a></li>
        
        <li><a href="my_attendance.php">My Attendance</a></li>
        
        <li><a href="generate_slip.php?id=<?php echo $_SESSION['emp_id']; ?>">Salary Slip</a></li>
        
        <li>
            <a href="logout.php" style="color: #ff7675;" onclick="return confirm('क्या आप वाकई लॉगआउट करना चाहते हैं?')">
                Logout
            </a>
        </li>
        
    </ul>
</div>

<style>
    /* Sidebar Styles for Employee */
    .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; position: fixed; left: 0; top: 0; }
    .sidebar h2 { text-align: center; padding: 20px; background: #1a252f; margin: 0; font-size: 20px; border-bottom: 1px solid #34495e; }
    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar ul li { padding: 0; border-bottom: 1px solid #34495e; }
    .sidebar ul li a { color: #ecf0f1; text-decoration: none; display: block; padding: 15px 20px; transition: 0.3s; }
    .sidebar ul li a:hover { background: #34495e; padding-left: 25px; }
</style>