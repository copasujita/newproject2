<?php
session_start();
include('connection.php'); // आपके एडमिन फोल्डर में मौजूद कनेक्शन फाइल

if(!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['send'])){
    $emp_id = $_POST['employee_id'];
    $msg = $_POST['message'];
    
    // मैसेज को डेटाबेस में सेव करें
    $stmt = $conn->prepare("INSERT INTO messages (employee_id, admin_msg) VALUES (?, ?)");
    $stmt->bind_param("is", $emp_id, $msg);
    $stmt->execute();
    echo "<script>alert('Message Sent Successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Send Message</title></head>
<body>
    <?php include('sidebar.php'); ?> <div style="margin-left:260px; padding:30px;">
        <h1>Send Message to Employee</h1>
        <form method="POST">
            <label>Select Employee:</label><br>
            <select name="employee_id" required style="width:100%; padding:10px;">
                <?php
                $res = $conn->query("SELECT id, name FROM employees");
                while($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select><br><br>
            <label>Message:</label><br>
            <textarea name="message" required style="width:100%; height:100px; padding:10px;"></textarea><br><br>
            <button name="send" style="padding:10px 20px; background:#27ae60; color:white; border:none;">Send Message</button>
        </form>
    </div>
</body>
</html>