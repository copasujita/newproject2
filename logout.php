<?php
// 1. सेशन शुरू करें ताकि उसे एक्सेस किया जा सके
session_start();

// 2. सेशन के अंदर के सभी वेरिएबल्स (जैसे admin_user, role, logged_in) को खाली करें
session_unset();

// 3. सर्वर से सेशन को पूरी तरह नष्ट (Destroy) करें
session_destroy();

// 4. लॉगिन पेज पर वापस भेजें
header("Location: login.php");
exit();
?>