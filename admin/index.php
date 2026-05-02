<?php
session_start();

// डेटाबेस कनेक्शन (employees टेबल चेक करने के लिए)
$conn = new mysqli("localhost", "root", "", "ems_db");

// 1. Admin के लिए फिक्स्ड क्रेडेंशियल्स
$fixed_admin_user = "admin";
$fixed_admin_pass = "123";

$error = "";

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 2. पहले Admin चेक करें (Fixed Variable Method)
    if ($user === $fixed_admin_user && $pass === $fixed_admin_pass) {
        $_SESSION['admin_user'] = $user;
        $_SESSION['role'] = 'admin'; // रोल सेट करें
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } 
    
    // 3. अगर Admin नहीं है, तो Employee Table चेक करें (Database Method)
    else {
        // SQL Injection से बचने के लिए तैयार क्वेरी
        $stmt = $conn->prepare("SELECT id, name FROM employees WHERE email = ? AND phone = ?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $emp_data = $result->fetch_assoc();
            
            $_SESSION['emp_id'] = $emp_data['id'];
            $_SESSION['emp_name'] = $emp_data['name'];
            $_SESSION['role'] = 'employee'; // रोल सेट करें
            $_SESSION['logged_in'] = true;
            
            header("Location: ../employee_dashboard.php");
            exit();
        } else {
            $error = "गलत यूजरनेम (Email) या पासवर्ड (Phone)!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Login - Admin & Employee</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 350px; }
        .login-container h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 10px; background-color: #2c3e50; border: none; color: white; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn-login:hover { background-color: #1a252f; }
        .error { color: red; font-size: 14px; text-align: center; margin-bottom: 10px; background: #ffeaea; padding: 5px; border-radius: 4px; }
        .note { font-size: 12px; color: #666; text-align: center; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>EMS Login</h2>
    
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Username / Email</label>
            <input type="text" name="username" placeholder="Admin user or Emp Email" required>
        </div>
        <div class="form-group">
            <label>Password / Phone</label>
            <input type="password" name="password" placeholder="Password or Phone" required>
        </div>
        <button type="submit" name="login" class="btn-login">Sign In</button>
    </form>

    <div class="note">
        <strong>Admin:</strong> Use fixed user/pass.<br>
        <strong>Employee:</strong> Use your Email & Phone.
    </div>
</div>

</body>
</html>