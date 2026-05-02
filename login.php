<?php
session_start();
// डेटाबेस कनेक्शन फ़ाइल (सुनिश्चित करें कि config.php सही पाथ पर है)
include('config.php'); 

$error = "";

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Admin के लिए फिक्स्ड क्रेडेंशियल्स चेक करें
    if ($user === "admin" && $pass === "123") {
        $_SESSION['admin_user'] = $user;
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_in'] = true;
        // एडमिन को उसके फोल्डर के अंदर वाले डैशबोर्ड पर भेजें
        header("Location: admin/dashboard.php"); 
        exit();
    } 
    
    // 2. कर्मचारी के लिए डेटाबेस में चेक करें
    else {
        $stmt = $conn->prepare("SELECT id, name FROM employees WHERE email = ? AND phone = ?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $emp_data = $result->fetch_assoc();
            
            $_SESSION['emp_id'] = $emp_data['id'];
            $_SESSION['emp_name'] = $emp_data['name'];
            $_SESSION['role'] = 'employee';
            $_SESSION['logged_in'] = true;
            
            header("Location: employee_dashboard.php"); // कर्मचारी डैशबोर्ड पर भेजें
            exit();
        } else {
            $error = "गलत यूजरनेम (Email) या पासवर्ड (Phone)!";
        }
    }
}

// सबसे ऊपर Header शामिल करें
include('header.php'); 
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Login - Admin & Employee</title>
    <style>
        /* पेज को सुव्यवस्थित करने के लिए CSS */
        .page-container {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f2f5;
            padding: 50px 0;
        }
        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 24px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 380px; 
        }
        .login-card h2 { text-align: center; color: #1a252f; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 14px; 
        }
        .form-group input:focus { 
            border-color: #3498db; 
            outline: none; 
            box-shadow: 0 0 5px rgba(52,152,219,0.3); 
        }
        .btn-login { 
            width: 100%; 
            padding: 12px; 
            background-color: #2c3e50; 
            border: none; 
            color: white; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold; 
            transition: 0.3s; 
        }
        .btn-login:hover { background-color: #1a252f; }
        .error { 
            color: #d63031; 
            font-size: 14px; 
            text-align: center; 
            margin-bottom: 15px; 
            background: #ff767533; 
            padding: 10px; 
            border-radius: 6px; 
        }
        .info-note { 
            font-size: 12px; 
            color: #7f8c8d; 
            text-align: center; 
            margin-top: 20px; 
            border-top: 1px solid #eee; 
            padding-top: 15px; 
        }
        .reg-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .reg-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="page-container">
    <div class="login-card">
        <h2>EMS Portal Login</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username / Email</label>
                <input type="text" name="username" placeholder="Admin username or Employee Email" required>
            </div>
            <div class="form-group">
                <label>Password / Phone</label>
                <input type="password" name="password" placeholder="Password or Phone Number" required>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>

        <div class="reg-link">
            नया कर्मचारी? <a href="register.php">यहाँ रजिस्टर करें</a>
        </div>

        <div class="info-note">
            <strong>Admin:</strong> Use fixed credentials.<br>
            <strong>Employee:</strong> Use your registered Email & Phone.
        </div>
    </div>
</div>

<?php 
// अंत में Footer शामिल करें
include('footer.php'); 
?>
</body>
</html>