<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit(); }

$conn = new mysqli("localhost", "root", "", "ems_db");

// ID चेक करें (Security के लिए)
if(!isset($_GET['id'])) { die("कर्मचारी ID नहीं मिली!"); }
$id = intval($_GET['id']);

// डेटाबेस से जानकारी निकालें
$query = "SELECT *, 
         (SELECT COUNT(id) FROM attendance 
          WHERE emp_id = employees.id 
          AND MONTH(attendance_date) = MONTH(CURRENT_DATE) 
          AND status = 'Present') as p_days 
          FROM employees WHERE id = $id";

$res = $conn->query($query);
$emp = $res->fetch_assoc();

if (!$emp) { die("रिकॉर्ड नहीं मिला!"); }

// कैलकुलेशन: अगर कर्मचारी 0 दिन प्रेजेंट है तो सैलरी 0 होगी
$days_in_month = 30; 
$final_pay = ($emp['salary'] / $days_in_month) * $emp['p_days'];
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - <?php echo $emp['name']; ?></title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 10px; }
        
        /* रिस्पॉन्सिव बॉक्स */
        .slip-box { 
            max-width: 700px; 
            width: 100%;
            padding: 30px; 
            border: 1px solid #ccc; 
            margin: 20px auto; 
            background: #fff; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            box-sizing: border-box;
            border-radius: 8px;
        }

        .header { 
            text-align: center; 
            border-bottom: 2px solid #2c3e50; 
            padding-bottom: 15px; 
            margin-bottom: 20px;
        }
        .header h2 { margin: 0; color: #2c3e50; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #7f8c8d; }

        /* टेबल स्टाइलिंग */
        .details { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .details td { padding: 12px; border: 1px solid #eee; font-size: 15px; }
        .details tr:nth-child(even) { background: #f9f9f9; }
        .details strong { color: #34495e; }

        .total { background: #2c3e50 !important; color: #fff; font-weight: bold; }
        .total td { border: none; font-size: 18px; }

        /* प्रिंट बटन */
        .print-btn { 
            display: block; 
            width: 150px; 
            margin: 20px auto; 
            padding: 12px; 
            background: #27ae60; 
            color: white; 
            text-align: center; 
            cursor: pointer; 
            border: none; 
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        .print-btn:hover { background: #219150; }

        /* मोबाइल के लिए विशेष नियम */
        @media (max-width: 480px) {
            .slip-box { padding: 15px; }
            .details td { display: block; width: 100%; box-sizing: border-box; border: none; padding: 8px 5px; }
            .details tr { border-bottom: 1px solid #eee; display: block; margin-bottom: 10px; }
            .header h2 { font-size: 20px; }
        }

        /* प्रिंट मोड के लिए सेटिंग */
        @media print { 
            body { background: white; padding: 0; }
            .print-btn, .sidebar { display: none !important; } 
            .slip-box { border: 2px solid #000; box-shadow: none; margin: 0 auto; width: 100%; }
        }
    </style>
</head>
<body>

<div class="slip-box">
    <div class="header">
        <h2>Employee Management System</h2>
        <p>Salary Slip: <strong><?php echo date('F Y'); ?></strong></p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Employee Name</strong></td>
            <td><?php echo $emp['name']; ?></td>
        </tr>
        <tr>
            <td><strong>Department</strong></td>
            <td><?php echo $emp['department']; ?></td>
        </tr>
        <tr>
            <td><strong>Base Salary</strong></td>
            <td>₹<?php echo number_format($emp['salary'], 2); ?></td>
        </tr>
        <tr>
            <td><strong>Working Days (Present)</strong></td>
            <td><?php echo $emp['p_days']; ?> Days</td>
        </tr>
        <tr class="total">
            <td><strong>Net Salary Payable</strong></td>
            <td>₹<?php echo number_format($final_pay, 2); ?></td>
        </tr>
    </table>

    <div style="margin-top: 50px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div style="font-size: 12px; color: #999;">Generated on: <?php echo date('d-m-Y'); ?></div>
        <div style="text-align: center; border-top: 1px solid #000; width: 150px; padding-top: 5px;">
            Authorized Signature
        </div>
    </div>
</div>

<button class="print-btn" onclick="window.print()">Download / Print</button>

</body>
</html>