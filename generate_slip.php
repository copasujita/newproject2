<?php
session_start();

// सुरक्षा चेक: क्या यूजर लॉगिन है?
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ems_db");

// URL से कर्मचारी की ID प्राप्त करें
if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
} else {
    echo "कर्मचारी की ID नहीं मिली!";
    exit();
}

// 1. कर्मचारी की जानकारी और इस महीने की प्रेजेंट हाज़िरी निकालें
$month = date('m');
$year = date('Y');

$sql = "SELECT e.*, 
        (SELECT COUNT(id) FROM attendance WHERE emp_id = e.id AND MONTH(attendance_date) = '$month' AND YEAR(attendance_date) = '$year' AND status = 'Present') as present_days 
        FROM employees e WHERE e.id = $emp_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $emp = $result->fetch_assoc();
} else {
    echo "डेटाबेस में कोई कर्मचारी नहीं मिला!";
    exit();
}

// 2. सैलरी कैलकुलेशन (30 दिन के आधार पर)
$basic_salary = $emp['salary'];
$per_day_salary = $basic_salary / 30;
$net_salary = $per_day_salary * $emp['present_days'];

?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>Salary Slip - <?php echo $emp['name']; ?></title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .slip-wrapper { max-width: 700px; margin: auto; background: white; padding: 30px; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        
        .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-section div { width: 48%; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background: #f9f9f9; }
        
        .total-row { background: #2c3e50; color: white; font-weight: bold; font-size: 18px; }
        
        .footer { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature { border-top: 1px solid #333; width: 150px; text-align: center; padding-top: 5px; }
        
        .no-print { text-align: center; margin-top: 20px; }
        .btn-print { background: #27ae60; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; font-size: 16px; }

        /* प्रिंट करते समय बटन और बैकग्राउंड न दिखे */
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .slip-wrapper { border: none; box-shadow: none; width: 100%; }
        }
    </style>
</head>
<body>

<div class="slip-wrapper">
    <div class="header">
        <h2>Employee Management System</h2>
        <p>Salary Slip for the Month of <strong><?php echo date('F, Y'); ?></strong></p>
    </div>

    <div class="info-section">
        <div>
            <p><strong>Employee ID:</strong> #<?php echo $emp['id']; ?></p>
            <p><strong>Name:</strong> <?php echo $emp['name']; ?></p>
            <p><strong>Department:</strong> <?php echo $emp['department']; ?></p>
        </div>
        <div style="text-align: right;">
            <p><strong>Email:</strong> <?php echo $emp['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $emp['phone']; ?></p>
            <p><strong>Date:</strong> <?php echo date('d-m-Y'); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Monthly Base Salary</td>
                <td>₹ <?php echo number_format($basic_salary, 2); ?></td>
            </tr>
            <tr>
                <td>Total Working Days (Present)</td>
                <td><?php echo $emp['present_days']; ?> Days</td>
            </tr>
            <tr>
                <td>Deduction (Absents)</td>
                <td>₹ <?php echo number_format($basic_salary - $net_salary, 2); ?></td>
            </tr>
            <tr class="total-row">
                <td>Net Payable Salary</td>
                <td>₹ <?php echo number_format($net_salary, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">Employee Signature</div>
        <div class="signature">Admin / HR Signature</div>
    </div>
</div>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">Print Salary Slip</button>
    <p><a href="javascript:history.back()">Back to Dashboard</a></p>
</div>

</body>
</html>