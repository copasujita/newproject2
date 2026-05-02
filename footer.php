<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMS Footer</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body{
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            background:#f4f6f9;
        }

        /* Footer */
        .footer{
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color:white;
            padding:30px 50px 15px;
            margin-top:50px;
        }

        .footer-content{
            display:flex;
            justify-content:space-between;
            flex-wrap:wrap;
        }

        .footer-box{
            width:30%;
            min-width:250px;
            margin-bottom:20px;
        }

        .footer-box h3{
            margin-bottom:15px;
            color:#ffd700;
        }

        .footer-box p{
            font-size:14px;
            line-height:1.6;
        }

        .footer-box ul{
            list-style:none;
            padding:0;
        }

        .footer-box ul li{
            margin-bottom:10px;
        }

        .footer-box ul li a{
            color:white;
            text-decoration:none;
            transition:0.3s;
        }

        .footer-box ul li a:hover{
            color:#ffd700;
            padding-left:5px;
        }

        /* Social Icons */
        .social a{
            color:white;
            font-size:18px;
            margin-right:15px;
            transition:0.3s;
        }

        .social a:hover{
            color:#ffd700;
        }

        /* Bottom */
        .footer-bottom{
            text-align:center;
            border-top:1px solid rgba(255,255,255,0.3);
            padding-top:10px;
            font-size:14px;
            margin-top:10px;
        }
    </style>
</head>
<body>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">

        <div class="footer-box">
            <h3>Employee Management System</h3>
            <p>
                EMS helps manage employees, attendance, salary and records
                efficiently with a secure and user-friendly system.
            </p>
        </div>

        <div class="footer-box">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Employees</a></li>
                <li><a href="#">Attendance</a></li>
                <li><a href="#">Salary</a></li>
            </ul>
        </div>

        <div class="footer-box">
            <h3>Follow Us</h3>
            <div class="social">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Employee Management System | Designed by You
    </div>
</footer>

</body>
</html>
