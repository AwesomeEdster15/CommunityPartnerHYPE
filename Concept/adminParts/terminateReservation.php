<?php require "../sharedParts/header.php"; ?>
<?php
	require_once "../database/config.php";

	if (!isset($_SESSION["isAdmin"]))
	{
		header("Location: ../accountParts/login.php");
	}
	

$acceptSQL = "UPDATE Reservation SET status='Terminated' WHERE reservationID=" . $_GET['reservationID'] . ";";

if($stmt = mysqli_prepare($dbCon, $acceptSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "");
  #Set parameters
  #Attempt to execute prepared statement
  if(mysqli_stmt_execute($stmt)) {
    #Redirect to view all items page --- might change this later to go to the product page itself, but it doesn't exist yet
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } else {
    echo "Oops! Something went wrong. Please try again later. :)";
  }
  #Close statement
  mysqli_stmt_close($stmt);
}
mysqli_close($dbCon);
?>
