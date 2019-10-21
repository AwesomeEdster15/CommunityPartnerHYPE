<?php if (!isset($_SESSION)) session_start();
#unset all session variables
$_SESSION = array();
#Destroy the Session
session_destroy();
#Redirect to login page
header("location: ../mainPages/main.php");
exit;
?>
