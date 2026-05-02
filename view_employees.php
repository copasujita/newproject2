<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ems_db");
$msg = "";

if (isset($_POST['add_emp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = $_POST['department'];
    $salary = $_POST['salary'];
    $j_date = $_POST['joining_date']; // Date input se value lena

    $sql = "INSERT INTO employees (name, email, department, salary, joining_date) 
            VALUES ('$name', '$email', '$dept', '$salary', '$j_date')";

    if ($conn->query($sql)) {
        $msg = "<p style='color:green;'>Employee Added Successfully!</p>";
    } else {
        $msg = "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <style>
        /* Sidebar logic same rakhein */
        .form-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="form-card">
            <h2>Add New Employee</h2>
            <?php echo $msg; ?>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="department" placeholder="Department" required>
                <input type="number" name="salary" placeholder="Salary" required>
                <label>Joining Date:</label>
                <input type="date" name="joining_date" required> <button type="submit" name="add_emp">Save Employee</button>
            </form>
        </div>
    </div>
</body>
</html>