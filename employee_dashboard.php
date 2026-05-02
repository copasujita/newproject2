<?php
session_start();

// सुरक्षा चेक
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ems_db");
$emp_id = $_SESSION['emp_id'];

// 1. कर्मचारी की जानकारी
$emp_res = $conn->query("SELECT * FROM employees WHERE id = $emp_id");
$emp = $emp_res->fetch_assoc();

// 2. वर्तमान महीने और साल का डेटा
$current_month = date('m');
$current_year = date('Y');
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

// Present Days
$p_res = $conn->query("SELECT COUNT(id) as total FROM attendance WHERE emp_id = $emp_id AND MONTH(attendance_date) = '$current_month' AND YEAR(attendance_date) = '$current_year' AND status = 'Present'");
$present_days = $p_res->fetch_assoc()['total'];

// Absent Days
$a_res = $conn->query("SELECT COUNT(id) as total FROM attendance WHERE emp_id = $emp_id AND MONTH(attendance_date) = '$current_month' AND YEAR(attendance_date) = '$current_year' AND status = 'Absent'");
$absent_days = $a_res->fetch_assoc()['total'];

// प्रतिशत गणना
$present_pct = ($present_days / $days_in_month) * 100;
$absent_pct = ($absent_days / $days_in_month) * 100;
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f4f7f6; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #2c3e50; color: white; position: fixed; }
        .main-content { margin-left: 250px; padding: 30px; width: 100%; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 25px; }
        .card { background: white; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .progress-container { background: #eee; border-radius: 20px; height: 25px; width: 100%; margin: 10px 0 20px 0; overflow: hidden; }
        .bar-present { background: #27ae60; height: 100%; color: white; text-align: center; }
        .bar-absent { background: #e74c3c; height: 100%; color: white; text-align: center; }
    </style>
</head>
<body>

<?php include('sidebar_emp.php'); ?>

<div class="main-content">
    <h1>नमस्ते, <?php echo $emp['name']; ?>!</h1>
    
    <div class="stats-grid">
        <div class="card"><h3>Department</h3><p><?php echo $emp['department']; ?></p></div>
        <div class="card"><h3>Present</h3><p><?php echo $present_days; ?> Days</p></div>
        <div class="card"><h3>Absent</h3><p><?php echo $absent_days; ?> Days</p></div>
    </div>

    

    <div class="card">
        <h2>मासिक उपस्थिति (<?php echo date('F Y'); ?>)</h2>
        
        <label>Present: <?php echo round($present_pct); ?>%</label>
        <div class="progress-container">
            <div class="bar-present" style="width: <?php echo $present_pct; ?>%;"><?php echo round($present_pct); ?>%</div>
        </div>

        <label>Absent: <?php echo round($absent_pct); ?>%</label>
        <div class="progress-container">
            <div class="bar-absent" style="width: <?php echo $absent_pct; ?>%;"><?php echo round($absent_pct); ?>%</div>
        </div>
    </div>
</div>

</body>
</html> 