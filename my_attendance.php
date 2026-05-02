<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "ems_db");
$emp_id = $_SESSION['emp_id'];

// इस महीने की हाज़िरी निकालना
$res = $conn->query("SELECT * FROM attendance WHERE emp_id = $emp_id ORDER BY attendance_date DESC");
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>My Attendance</title>
    <style>
        body { font-family: Arial; margin: 0; display: flex; background: #f4f7f6; }
        .content { margin-left: 250px; padding: 30px; width: 100%; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #2c3e50; color: white; }
        .Present { color: green; font-weight: bold; }
        .Absent { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <?php include('sidebar_emp.php'); ?>
    <div class="content">
        <h1>My Attendance History</h1>
        <table>
            <tr><th>Date</th><th>Status</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo date('d-M-Y', strtotime($row['attendance_date'])); ?></td>
                <td class="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>