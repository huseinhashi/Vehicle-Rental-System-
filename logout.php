<?php
session_start();
// Include cache control headers
header("Pragma: no-cache");
// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Redirect to the login page
header("Location:index.php");
exit();
?>