<?php
session_start();
include('config.php'); // डेटाबेस कनेक्शन फ़ाइल

$message = "";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    // ईमेल डुप्लीकेट चेक
    $check_email = "SELECT id FROM employees WHERE email = '$email'";
    $run_check = $conn->query($check_email);

    if ($run_check->num_rows > 0) {
        $message = "<div class='alert alert-danger'>यह ईमेल पहले से रजिस्टर है!</div>";
    } else {
        // डेटाबेस में कर्मचारी को जोड़ना
        $sql = "INSERT INTO employees (name, email, phone, department, salary) 
                VALUES ('$name', '$email', '$phone', '$dept', '$salary')";

        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>रजिस्ट्रेशन सफल! अब आप लॉगिन कर सकते हैं।</div>";
        } else {
            $message = "<div class='alert alert-danger'>त्रुटि: " . $conn->error . "</div>";
        }
    }
}

// सबसे पहले Header include करें
include('header.php'); 
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>Employee Registration | EMS</title>
    <style>
        /* बॉडी का बैकग्राउंड और डिस्प्ले सेटिंग्स */
        .reg-wrapper {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f4f4;
            padding: 20px 0;
        }
        .reg-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .reg-box h2 {
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: bold;
        }
        .reg-box input, .reg-box select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
        }
        .reg-box button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
        }
        .reg-box button:hover {
            background: #2980b9;
        }
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-success { background: #d4edda; color: #155724; }
        .footer-links {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .footer-links a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="reg-wrapper">
    <div class="reg-box">
        <h2>New Registration</h2>
        
        <?php echo $message; ?>
        
        <form method="POST">
            <input type="text" name="name" placeholder="पूरा नाम (Full Name)" required>
            <input type="email" name="email" placeholder="ईमेल पता (Email)" required>
            <input type="text" name="phone" placeholder="फ़ोन नंबर (Password के लिए)" required>
            
            <select name="dept" required>
                <option value="">विभाग चुनें (Select Dept)</option>
                <option value="IT">IT Department</option>
                <option value="HR">HR Department</option>
                <option value="Sales">Sales</option>
                <option value="Marketing">Marketing</option>
            </select>
            
            <input type="number" name="salary" placeholder="उपेक्षित वेतन (Expected Salary)" required>
            
            <button type="submit" name="register">अभी रजिस्टर करें</button>
        </form>
        
        <div class="footer-links">
            पहले से अकाउंट है? <a href="login.php">यहाँ लॉगिन करें</a>
        </div>
    </div>
</div>

<?php 
// अंत में Footer include करें
include('footer.php'); 
?>

</body>
</html>