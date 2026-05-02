<?php
session_start();
// इसमें हम header.php को शामिल कर रहे हैं जो आपने पहले बनाई है
include('header.php'); 
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>About Us - EMS Project</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f7f6; margin: 0; }
        .about-container { max-width: 1000px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .about-header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .about-header h1 { color: #2c3e50; margin: 0; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px; }
        .feature-card { padding: 20px; background: #f9f9f9; border-radius: 8px; border-top: 4px solid #3498db; transition: 0.3s; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .feature-card h3 { color: #2980b9; margin-top: 0; }
        .project-goal { background: #e8f4fd; padding: 20px; border-radius: 8px; margin-top: 30px; border-left: 5px solid #3498db; }
        .back-link { display: inline-block; margin-top: 30px; text-decoration: none; color: #3498db; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="about-container">
    <div class="about-header">
        <h1>(About EMS)</h1>
        <p>एक सरल और सुरक्षित कर्मचारी प्रबंधन समाधान</p>
    </div>

    <div class="project-goal">
        <h3>हमारा उद्देश्य</h3>
        <p>यह **Employee Management System (EMS)** संगठनों को उनके कर्मचारियों के डेटा, हाज़िरी (Attendance), और पेरोल (Payroll) को डिजिटल रूप से प्रबंधित करने में मदद करने के लिए बनाया गया है।</p>
    </div>

    <h2>मुख्य विशेषताएं</h2>
    <div class="feature-grid">
        <div class="feature-card">
            <h3>👥 कर्मचारी प्रबंधन</h3>
            <p>एडमिन आसानी से नए कर्मचारियों को जोड़ सकते हैं और उनके रिकॉर्ड देख सकते हैं।</p>
        </div>
        <div class="feature-card">
            <h3>📅 हाज़िरी ट्रैकिंग</h3>
            <p>कर्मचारी अपनी रोज़ाना की उपस्थिति देख सकते हैं और एडमिन इसे मैनेज कर सकते हैं।</p>
        </div>
        <div class="feature-card">
            <h3>💰 सैलरी स्लिप</h3>
            <p>डिजिटल सैलरी स्लिप (Salary Slips) तुरंत जेनरेट की जा सकती हैं।</p>
        </div>
        <div class="feature-card">
            <h3>✉️ आंतरिक संचार</h3>
            <p>एडमिन सीधे कर्मचारियों को महत्वपूर्ण संदेश भेज सकते हैं।</p>
        </div>
    </div>

    <p style="text-align:center;">
        <a href="index.php" class="back-link">← होम पेज पर वापस जाएं</a>
    </p>
</div>

<?php include('footer.php'); // आपकी footer.php फ़ाइल ?>

</body>
</html>