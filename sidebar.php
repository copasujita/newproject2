<?php
session_start();
if (!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit(); }
$conn = new mysqli("localhost", "root", "", "ems_db");

$total_emp = $conn->query("SELECT COUNT(id) as total FROM employees")->fetch_assoc()['total'];
$today = date('Y-m-d');
$today_present = $conn->query("SELECT COUNT(id) as present FROM attendance WHERE attendance_date = '$today' AND status = 'Present'")->fetch_assoc()['present'];
?>

<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EMS Admin Dashboard</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Segoe UI',sans-serif;
background:#f4f7f6;
}

/* Sidebar */

.admin-sidebar{
width:260px;
height:100vh;
background:#2c3e50;
color:#fff;
position:fixed;
top:0;
left:-260px;
transition:0.4s;
z-index:1000;
}

.admin-sidebar.active{
left:0;
}

.sidebar-brand{
padding:20px;
background:#1a252f;
text-align:center;
}

.admin-sidebar ul{
list-style:none;
padding-top:20px;
}

.admin-sidebar a{
display:block;
padding:15px 25px;
color:white;
text-decoration:none;
transition:0.3s;
}

.admin-sidebar a:hover{
background:#34495e;
}

/* Overlay */

.overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.3);
display:none;
z-index:900;
}

.overlay.active{
display:block;
}

/* Navbar */

.navbar{
height:60px;
background:white;
width:100%;
position:fixed;
top:0;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 20px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
z-index:999;
}

.menu-btn{
font-size:22px;
cursor:pointer;
}

/* Main Content */

.main-content{
margin-top:80px;
padding:20px;
transition:0.4s;
}

/* Cards */

.card-container{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

.card{
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
text-align:center;
border-top:4px solid #3498db;
}

.card h3{
margin-bottom:10px;
}

/* Quick Section */

.quick{
margin-top:20px;
background:white;
padding:20px;
border-radius:10px;
}

/* Tablet */

@media(max-width:768px){

.navbar{
padding:0 15px;
}

.main-content{
padding:15px;
}

}

/* Desktop */

@media(min-width:993px){

.admin-sidebar{
left:0;
}

.navbar{
width:calc(100% - 260px);
margin-left:260px;
}

.main-content{
margin-left:260px;
}

.menu-btn{
display:none;
}

.overlay{
display:none !important;
}

}

</style>
</head>

<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="admin-sidebar" id="sidebar">

<div class="sidebar-brand">
<h2>EMS Admin</h2>
</div>

<ul>
<li><a href="dashboard.php">📊 Dashboard</a></li>
<li><a href="attendance.php">📅 Attendance</a></li>
<li><a href="logout.php" style="color:#e74c3c;">🚪 Logout</a></li>
</ul>

</div>

<div class="navbar">

<div class="menu-btn" onclick="toggleSidebar()">☰</div>

<div>
Welcome, <strong>Admin</strong>
</div>

</div>

<div class="main-content">

<h1>Dashboard</h1>

<div class="card-container">

<div class="card">
<h3>Total Employees</h3>
<p style="font-size:30px;font-weight:bold;">
<?php echo $total_emp; ?>
</p>
</div>

<div class="card" style="border-top-color:#2ecc71;">
<h3>Today Present</h3>
<p style="font-size:30px;font-weight:bold;">
<?php echo $today_present; ?>
</p>
</div>

</div>

<section class="quick">
<h2>Quick Overview</h2>
<p>आज की तारीख: <?php echo date('d-M-Y'); ?></p>
</section>

</div>

<script>

function toggleSidebar(){

document.getElementById("sidebar").classList.toggle("active");
document.getElementById("overlay").classList.toggle("active");

}

</script>

</body>
</html>