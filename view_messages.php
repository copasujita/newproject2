<?php
session_start();
include('config.php'); // डेटाबेस कनेक्शन फाइल

// सुरक्षा चेक
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

$emp_id = $_SESSION['emp_id'];

// एडमिन द्वारा इस कर्मचारी को भेजे गए मैसेज निकालना
$sql = "SELECT * FROM messages WHERE employee_id = $emp_id ORDER BY sent_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>Messages from Admin</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; margin: 0; background: #f4f7f6; }
        .content { margin-left: 260px; padding: 30px; width: 100%; }
        .msg-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #3498db; shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .msg-date { font-size: 12px; color: #888; margin-bottom: 8px; }
        .no-msg { text-align: center; color: #7f8c8d; margin-top: 50px; }
    </style>
</head>
<body>
    <?php include('sidebar_emp.php'); ?> <div class="content">
        <h1>Admin Messages</h1>
        <hr>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="msg-card">
                    <div class="msg-date">भेजा गया: <?php echo date('d M Y, h:i A', strtotime($row['sent_at'])); ?></div>
                    <p><?php echo htmlspecialchars($row['admin_msg']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-msg">
                <h3>अभी तक कोई नया संदेश नहीं है।</h3>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>