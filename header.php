<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', sans-serif; }
        
        /* Main Header */
        .main-header {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { color:white; font-size:26px; font-weight:bold; display:flex; align-items:center; }
        .logo i { margin-right:10px; color:#ffd700; }

        /* Desktop Menu */
        .menu { display: flex; align-items: center; }
        .menu a { 
            color:white; 
            text-decoration:none; 
            margin-left:15px; 
            font-size:16px; 
            padding:8px 14px; 
            border-radius:5px; 
            transition:0.3s; 
        }
        .menu a:hover { background:rgba(255,255,255,0.2); }
        .menu .btn-login { background:#27ae60; }

        /* Toggle Button (Desktop पर छिपा रहेगा) */
        .menu-toggle {
            display: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        /* --- Mobile Responsive CSS --- */
        @media (max-width: 992px) {
            .menu-toggle {
                display: block; /* मोबाइल पर दिखाएं */
            }

            .menu {
                position: absolute;
                top: 100%;
                left: -100%; /* शुरुआत में स्क्रीन से बाहर */
                width: 100%;
                height: auto;
                background: #1e3c72;
                flex-direction: column;
                padding: 20px 0;
                transition: 0.5s;
                box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            }

            /* जब सक्रिय (Active) हो */
            .menu.active {
                left: 0;
            }

            .menu a {
                margin: 10px 0;
                width: 80%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="logo">
        <i class="fa-solid fa-users-gear"></i> EMS
    </div>

    <div class="menu-toggle" id="mobile-menu">
        <i class="fa fa-bars"></i>
    </div>

    <nav class="menu" id="nav-list">
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
        <a href="about.php"><i class="fa fa-info-circle"></i> About</a>
        <a href="register.php"><i class="fa fa-user-plus"></i> Register</a>
        <a href="contact.php"><i class="fa fa-phone"></i> Contact</a>
        <a href="login.php" class="btn-login"><i class="fa fa-sign-in-alt"></i> Login</a>
    </nav>
</header>

<script>
    const menuToggle = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    menuToggle.addEventListener('click', () => {
        navList.classList.toggle('active');
        
        // आइकॉन को 'Bars' से 'X' (Close) में बदलने के लिए
        const icon = menuToggle.querySelector('i');
        if (navList.classList.contains('active')) {
            icon.classList.replace('fa-bars', 'fa-xmark');
        } else {
            icon.classList.replace('fa-xmark', 'fa-bars');
        }
    });
</script>

</body>
</html>