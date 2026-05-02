<?php
session_start();
if (!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit(); 
}

$conn = new mysqli("localhost", "root", "", "ems_db");
$message = "";

if (isset($_POST['submit'])) {
    // Data ko clean aur safe banayein
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dept = mysqli_real_escape_string($conn, $_POST['department']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    
    // Date Logic: Agar date select nahi ki, toh aaj ki date auto-pick hogi
    $date = $_POST['joining_date'];
    if (empty($date)) {
        $date = date('Y-m-d'); 
    }

    // SQL Query (Saare columns screenshot ke hisaab se)
    $sql = "INSERT INTO employees (name, email, phone, department, joining_date, salary) 
            VALUES ('$name', '$email', '$phone', '$dept', '$date', '$salary')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-success'>कर्मचारी का डेटा सफलतापूर्वक सेव हो गया!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee - EMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; padding-top: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .btn-submit { background: #3498db; color: white; border-radius: 8px; padding: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container">
                <h3 class="text-center mb-4"><i class="fa fa-user-plus text-primary"></i> नया कर्मचारी जोड़ें</h3>
                
                <?php echo $message; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">नाम (Name)</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ईमेल (Email)</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">फ़ोन (Phone)</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">विभाग (Department)</label>
                            <select name="department" class="form-select">
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Sales">Sales</option>
                                <option value="Marketing">Marketing</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ज्वाइनिंग तिथि (Joining Date)</label>
                            <input type="date" name="joining_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">वेतन (Salary)</label>
                            <input type="number" name="salary" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-submit w-100 mt-3">डाटा सुरक्षित करें</button>
                    <a href="view_employees.php" class="btn btn-light w-100 mt-2">कर्मचारी लिस्ट देखें</a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>