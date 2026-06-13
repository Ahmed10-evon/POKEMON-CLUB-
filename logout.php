<?php
// logout.php
session_start();
session_unset();    // Clear session data
session_destroy();  // Destroy the session completely
header("Location: index.php"); // Redirect to home
exit();
?>