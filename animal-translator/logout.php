<?php
// Start a PHP session
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>