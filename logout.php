<?php
// logout.php

// Start the session
session_start();

// Destroy the session
session_destroy();
session_write_close();

// Clear session cookies
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Redirect to the login page or homepage
header("Location: login.html");
exit();
?>