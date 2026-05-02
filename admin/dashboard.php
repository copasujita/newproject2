<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: ../login.php"); exit(); }

$conn = new mysqli("localhost", "root", "", "ems_db");
$total_employees = $conn->query("SELECT COUNT(id) AS total FROM employees")->fetch_assoc()['total'];
$today = date('Y-m-d');
$count_att = $conn->query("SELECT COUNT(id) AS present_count FROM attendance WHERE attendance_date = '$today' AND status = 'Present'");
$today_present = ($count_att) ? $count_att->fetch_assoc()['present_count'] : 0;
$pending_tasks = 5; 
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Admin Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; background-color: #f4f7f6; display: flex; }
        
        /* Sidebar - Fixed */
        .sidebar { 
            width: 250px; 
            height: 100vh; 
            background: #2c3e50; 
            color: white; 
            position: fixed; 
            left: 0; 
            top: 0;
        }

        /* Main Content - Adjusted for Sidebar */
        .main-content { 
            margin-left: 250px; 
            padding: 25px; 
            width: calc(100% - 250px); 
        }

        header { 
            background: white; 
            padding: 20px; 
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .card-container { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin-top: 30px; 
        }

        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
            text-align: center; 
            border-top: 5px solid #3498db; 
        }

        .card p { font-size: 32px; font-weight: bold; margin: 10px 0; color: #2c3e50; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { width: 70px; } /* छोटा साइडबार */
            .sidebar .sidebar-text { display: none; } /* टेक्स्ट छुपाएं */
            .main-content { margin-left: 70px; width: calc(100% - 70px); }
        }

        @media (max-width: 600px) {
            .sidebar { display: none; } /* मोबाइल पर पूरा साइडबार गायब */
            .main-content { margin-left: 0; width: 100%; padding: 10px; }
            header { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <?php include('sidebar.php'); ?>
    </div>

    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="user-info">
                <span>👤 <strong><?php echo $_SESSION['admin_user'] ?? 'Admin'; ?></strong></span>
                <a href="logout.php" style="margin-left:15px; color: #e74c3c;">Log Out</a>
            </div>
        </header>

        

        <div class="card-container">
            <div class="card">
                <h3>Total Employees</h3>
                <p><?php echo $total_employees; ?></p>
            </div>
            <div class="card" style="border-top-color: #2ecc71;">
                <h3>Present Today</h3>
                <p><?php echo $today_present; ?></p>
            </div>
            <div class="card" style="border-top-color: #f1c40f;">
                <h3>Pending Tasks</h3>
                <p><?php echo $pending_tasks; ?></p>
            </div>
        </div>
    </div>

</body>
</html>