<?php
#Logout Page
#Equipment Loan WebApp
#Copyright 2019
?>

<?php
#Initialize the session
session_start();
#unset all session variables
$_SESSION = array();
#Destroy the Session
session_destroy();
#Redirect to login page
header("location: login.php");
exit;
?>
