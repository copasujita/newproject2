<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Image Slider</title>
    <style>
        body { 
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f6f9; 
        }

        /* Slider Container: Ise Header ke barabar karne ke liye width 100% rakhi hai */
        .slider-wrapper {
            width: 100%;
            max-width: 100%; /* Header ke barabar failne ke liye */
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .slider {
            width: 100%;
            position: relative;
            overflow: hidden;
            /* Height ko auto rakha hai taaki image ke size ke hisab se adjust ho */
            height: 500px; 
        }

        .slides {
            display: flex;
            width: 300%; 
            height: 100%;
            animation: slide 15s infinite ease-in-out;
        }

        .slides img {
            width: 33.333%;
            height: 100%;
            /* 'cover' image ko fatne nahi deta, lekin agar image choti hai toh 'contain' use karein */
            object-fit: cover; 
            object-position: center;
        }

        @keyframes slide {
            0%, 25% { transform: translateX(0%); }
            33%, 58% { transform: translateX(-33.333%); }
            66%, 91% { transform: translateX(-66.666%); }
            100% { transform: translateX(0%); }
        }

        /* Overlay Caption */
        .caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 40px 20px 20px 20px;
            text-align: left;
        }

        .caption h2 { 
            margin: 0; 
            font-size: 2rem; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .caption p { 
            margin: 10px 0 0 0; 
            font-size: 1.1rem; 
            opacity: 0.9;
        }

        /* Mobile Responsive Settings */
        @media (max-width: 768px) {
            .slider { height: 300px; } /* Mobile pe height kam kar di */
            .caption h2 { font-size: 1.2rem; }
            .caption p { font-size: 0.9rem; }
        }
    </style>
</head>
<body>

<div class="slider-wrapper">
    <div class="slider">
        <div class="slides">
            <img src="images/ems1.jfif" alt="EMS Dashboard">
            <img src="images/ems2.jfif" alt="Employee Records">
            <img src="images/ems3.jfif" alt="Attendance System">
        </div>

        <div class="caption">
            <h2>Employee Management System</h2>
            <p>Manage Employees | Attendance | Salary</p>
        </div>
    </div>
</div>

</body>
</html>
<?php include "footer.php"; ?>