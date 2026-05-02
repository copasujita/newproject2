<?php
// 1. सेशन शुरू करें
session_start();

// 2. सेशन के सभी वेरिएबल्स को खाली करें
session_unset();

// 3. सेशन को पूरी तरह नष्ट (Destroy) करें
session_destroy();

// 4. लॉगिन पेज पर वापस भेजें
header("Location: index.php");
exit();
?>