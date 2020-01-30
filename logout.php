<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
$message = "Je bent succesvol uitgelogd.";
echo "<script type='text/javascript'>alert('$message');</script>";
header("location: index.php");
exit;
?>