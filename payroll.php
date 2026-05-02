<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ems_db");

$month = date('m');
$year = date('Y');

$sql = "SELECT e.id, e.name, e.salary, e.department,
        (SELECT COUNT(id) FROM attendance WHERE emp_id = e.id AND MONTH(attendance_date) = '$month' AND status = 'Present') as present_days
        FROM employees e";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management - EMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }

        /* Main Content Desktop */
        .main-content { 
            margin-left: 260px; 
            padding: 30px; 
            width: calc(100% - 260px); 
            transition: all 0.3s ease;
        }

        .header-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ddd;
        }

        h1 { color: #2c3e50; font-size: 24px; }

        .table-container {
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        th { background: #1a252f; color: white; padding: 15px; text-align: left; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; }
        
        .badge { background: #e8f4fd; color: #3498db; padding: 4px 10px; border-radius: 5px; font-weight: 600; }
        .salary-amount { color: #27ae60; font-weight: 700; }

        .btn-view { 
            background: #3498db; color: white; padding: 8px 12px; 
            text-decoration: none; border-radius: 5px; font-size: 13px;
        }

        /* --- MOBILE RESPONSIVE FIXES --- */
        @media (max-width: 992px) {
            .main-content { 
                margin-left: 0; 
                width: 100%; 
                padding: 100px 15px 20px 15px; /* Top padding badhai taaki heading dikhe */
            }

            .header-section {
                text-align: center;
                margin-top: 10px;
            }

            /* Table ko Cards mein badal diya mobile ke liye */
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            
            tr { 
                margin-bottom: 15px; 
                border: 1px solid #ddd; 
                border-radius: 8px; 
                background: #fff;
                padding: 10px;
            }

            td { 
                border: none;
                position: relative;
                padding-left: 50% !important; 
                text-align: right !important;
                border-bottom: 1px solid #f9f9f9;
            }

            td:before { 
                position: absolute;
                left: 15px;
                width: 45%; 
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
                content: attr(data-label);
                color: #555;
            }
            
            td:last-child { border-bottom: 0; }
        }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="header-section">
            <h1>Payroll Management <small>(<?php echo date('F Y'); ?>)</small></h1>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Base Salary</th>
                        <th>Attendance</th>
                        <th>Final Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): 
                        $per_day = $row['salary'] / 30;
                        $final_salary = $per_day * $row['present_days'];
                    ?>
                    <tr>
                        <td data-label="ID">#<?php echo $row['id']; ?></td>
                        <td data-label="Name"><strong><?php echo $row['name']; ?></strong></td>
                        <td data-label="Base Salary">₹<?php echo number_format($row['salary']); ?></td>
                        <td data-label="Attendance"><span class="badge"><?php echo $row['present_days']; ?> / 30</span></td>
                        <td data-label="Final Salary"><span class="salary-amount">₹<?php echo number_format($final_salary, 2); ?></span></td>
                        <td data-label="Action">
                            <a href="generate_slip.php?id=<?php echo $row['id']; ?>" class="btn-view">
                                <i class="fa-solid fa-file-invoice"></i> Slip
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>