<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// डेटाबेस कनेक्शन
$conn = new mysqli("localhost", "root", "", "ems_db");

$message = "";
$today = date('Y-m-d');

// Attendance Save करने का लॉजिक
if (isset($_POST['save_attendance'])) {
    $status_array = $_POST['status']; 

    foreach ($status_array as $emp_id => $status) {
        $emp_id = intval($emp_id);
        $status = $conn->real_escape_string($status);
        
        $check = $conn->query("SELECT id FROM attendance WHERE emp_id = $emp_id AND attendance_date = '$today'");
        
        if ($check->num_rows > 0) {
            $conn->query("UPDATE attendance SET status = '$status' WHERE emp_id = $emp_id AND attendance_date = '$today'");
        } else {
            $conn->query("INSERT INTO attendance (emp_id, attendance_date, status) VALUES ($emp_id, '$today', '$status')");
        }
    }
    $message = "<div class='alert success'>Attendance successfully updated for $today!</div>";
}

$employees = $conn->query("SELECT id, name FROM employees");
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance - EMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; display: flex; min-height: 100vh; }
        
        /* Main Content Layout */
        .main-content { 
            margin-left: 260px; 
            padding: 30px; 
            width: calc(100% - 260px); 
            transition: 0.3s;
        }

        .header-section { margin-bottom: 25px; }
        h1 { color: #2c3e50; font-size: 24px; }
        .date-badge { background: #e67e22; color: white; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 14px; }

        /* Table Design */
        .table-container {
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        table { width: 100%; border-collapse: collapse; }
        th { background: #34495e; color: white; padding: 15px; text-align: left; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 15px; }
        
        .radio-group { display: flex; gap: 20px; }
        .radio-group label { cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .radio-group input[type="radio"] { width: 18px; height: 18px; cursor: pointer; }

        .btn-submit { 
            background: #3498db; color: white; padding: 12px 30px; 
            border: none; border-radius: 6px; cursor: pointer; 
            margin-top: 25px; font-size: 16px; font-weight: bold;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #2980b9; transform: translateY(-2px); }

        .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* --- MOBILE RESPONSIVE LOGIC --- */
        @media (max-width: 992px) {
            .main-content { 
                margin-left: 0; 
                width: 100%; 
                padding: 100px 15px 30px 15px; /* Sidebar ke liye gap */
            }

            .header-section { text-align: center; }

            /* Table to Cards */
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            
            tr { 
                margin-bottom: 15px; 
                border: 1px solid #ddd; 
                border-radius: 8px; 
                background: #fff;
                padding: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            td { 
                border: none;
                position: relative;
                padding-left: 45% !important; 
                text-align: right !important;
                border-bottom: 1px solid #f1f1f1;
                min-height: 45px;
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }

            td:before { 
                position: absolute;
                left: 15px;
                width: 40%; 
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
                content: attr(data-label);
                color: #34495e;
            }
            
            td:last-child { border-bottom: 0; }
            .radio-group { gap: 10px; }
            .btn-submit { width: 100%; }
        }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="header-section">
            <h1>Daily Attendance</h1>
            <p style="margin-top: 5px;">तारीख: <span class="date-badge"><?php echo date('d-M-Y'); ?></span></p>
        </div>
        
        <?php echo $message; ?>

        <form method="POST">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Emp ID</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employees->num_rows > 0): ?>
                            <?php while($row = $employees->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Emp ID"><strong>#<?php echo $row['id']; ?></strong></td>
                                <td data-label="Name"><?php echo $row['name']; ?></td>
                                <td data-label="Status">
                                    <div class="radio-group">
                                        <label>
                                            <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Present" checked> 
                                            <span>P</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Absent"> 
                                            <span>A</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align:center;">कोई कर्मचारी नहीं मिला।</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" name="save_attendance" class="btn-submit">
                <i class="fa-solid fa-cloud-arrow-up"></i> Update Attendance
            </button>
        </form>
    </div>

</body>
</html>