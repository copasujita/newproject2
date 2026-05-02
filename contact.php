<?php
session_start();
include('config.php'); // सुनिश्चित करें कि $conn वेरिएबल यहाँ मौजूद है

$message = "";

if (isset($_POST['send_msg'])) {
    // डेटा को सुरक्षित करना (Sanitize)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $user_msg = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($name) && !empty($email) && !empty($user_msg)) {
        
        // डेटाबेस में डेटा डालने की क्वेरी
        $query = "INSERT INTO contact_queries (name, email, subject, message) 
                  VALUES ('$name', '$email', '$subject', '$user_msg')";

        if(mysqli_query($conn, $query)) {
            $message = "<div class='alert alert-success'>आपका संदेश डेटाबेस में सुरक्षित कर दिया गया है!</div>";
        } else {
            $message = "<div class='alert alert-danger'>त्रुटि: " . mysqli_error($conn) . "</div>";
        }
        
    } else {
        $message = "<div class='alert alert-danger'>कृपया सभी अनिवार्य फ़ील्ड भरें।</div>";
    }
}

include('header.php'); 
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - EMS</title>
    <style>
        .contact-wrapper {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f2f5;
            padding: 40px 20px;
        }
        .contact-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
        }
        .contact-info {
            background: #2c3e50;
            color: white;
            padding: 30px;
            border-radius: 10px;
        }
        .contact-info h3 { margin-top: 0; color: #3498db; }
        .contact-info p { font-size: 14px; line-height: 1.8; }
        
        .contact-form h2 { color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-send {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-send:hover { background: #2980b9; }
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }

        @media (max-width: 768px) {
            .contact-card { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="contact-wrapper">
    <div class="contact-card">
        <div class="contact-info">
            <h3>संपर्क जानकारी</h3>
            <p>📍 लखनऊ, उत्तर प्रदेश, भारत</p>
            <p>📞 +91 9876543210</p>
            <p>📧 support@ems-project.com</p>
            <hr style="border: 0.5px solid #444;">
            <p>किसी भी तकनीकी सहायता या फीडबैक के लिए हमें ईमेल करें। हम 24 घंटों के भीतर जवाब देने की कोशिश करते हैं।</p>
        </div>

        <div class="contact-form">
            <h2>हमें संदेश भेजें</h2>
            <?php echo $message; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label>आपका नाम</label>
                    <input type="text" name="name" placeholder="नाम लिखें" required>
                </div>
                <div class="form-group">
                    <label>ईमेल पता</label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label>विषय (Subject)</label>
                    <input type="text" name="subject" placeholder="किस बारे में है?" required>
                </div>
                <div class="form-group">
                    <label>संदेश</label>
                    <textarea name="message" rows="4" placeholder="अपना संदेश यहाँ लिखें..." required></textarea>
                </div>
                <button type="submit" name="send_msg" class="btn-send">संदेश भेजें</button>
            </form>
        </div>
    </div>
</div>



<?php include('footer.php'); // आपका फुटर शामिल करें ?>

</body>
</html>