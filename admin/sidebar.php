<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Admin Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* Sidebar Main Style */
        .sidebar {
            width: 260px; height: 100vh; background: #2c3e50; color: #fff;
            position: fixed; left: 0; top: 0; z-index: 1000;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 4px 0 10px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header { padding: 25px 20px; text-align: center; background: #1a252f; }
        .sidebar-header i { font-size: 30px; color: #3498db; margin-bottom: 10px; display: block; }
        .sidebar-header h2 { font-size: 20px; font-weight: 600; }
        .sidebar-header span { color: #3498db; }
        
        .sidebar-menu { list-style: none; padding: 20px 0; flex-grow: 1; overflow-y: auto; }
        .sidebar-menu li a {
            display: flex; align-items: center; padding: 15px 25px;
            color: #bdc3c7; text-decoration: none; transition: 0.3s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: #34495e; color: #fff; border-left: 4px solid #3498db;
        }
        .sidebar-menu li a i { font-size: 18px; width: 30px; }

        .logout-section { border-top: 1px solid #34495e; margin-top: auto; }

        /* Overlay for Mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 999;
            backdrop-filter: blur(3px);
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
            background: #3498db; color: white; width: 45px; height: 45px;
            border-radius: 8px; cursor: pointer;
            align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .mobile-toggle i { font-size: 22px; }

        /* --- Responsive Logic --- */
        @media (max-width: 992px) {
            .mobile-toggle { display: flex; } /* Mobile par toggle dikhega */
            
            .sidebar { 
                left: -260px; /* Default hide on mobile */
            } 
            
            .sidebar.active { 
                left: 0; /* Show on toggle */
            }
            
            .sidebar-overlay.active { 
                display: block; 
            }

            /* Main content area adjustment for mobile */
            .main-content { margin-left: 0 !important; padding-top: 70px !important; }
        }

        /* Desktop content adjustment */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: 0.3s;
        }
    </style>
</head>
<body>

    <div class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars" id="toggleIcon"></i>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-users-gear"></i>
            <h2>EMS <span>Admin</span></h2>
        </div>
        
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
            <li><a href="add_employee.php"><i class="fa-solid fa-user-plus"></i> <span>Add Employee</span></a></li>
            <li><a href="view_employees.php"><i class="fa-solid fa-users-viewfinder"></i> <span>View All</span></a></li>
            <li><a href="attendance.php"><i class="fa-solid fa-calendar-check"></i> <span>Attendance</span></a></li>
            <li><a href="payroll.php"><i class="fa-solid fa-money-bill-wave"></i> <span>Payroll</span></a></li>
            <li class="logout-section">
                <a href="logout.php" onclick="return confirm('क्या आप वाकई लॉगआउट करना चाहते हैं?')">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const icon = document.getElementById('toggleIcon');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Icon change effect
            if(sidebar.classList.contains('active')) {
                icon.classList.replace('fa-bars', 'fa-xmark');
            } else {
                icon.classList.replace('fa-xmark', 'fa-bars');
            }
        }

        // Close sidebar on window resize if it was open
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                document.getElementById('sidebar').classList.remove('active');
                document.getElementById('sidebarOverlay').classList.remove('active');
                document.getElementById('toggleIcon').classList.replace('fa-xmark', 'fa-bars');
            }
        });
    </script>
</body>
</html>