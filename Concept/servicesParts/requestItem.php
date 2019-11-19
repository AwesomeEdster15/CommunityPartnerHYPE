<?php require "../sharedParts/header.php"; ?>
<?php
	require_once "../database/config.php";

$itemID = 0;
$result = mysqli_query($dbCon,"SELECT itemID FROM Item WHERE ProductName='" . $_GET["productName"] . "';");
while($row = mysqli_fetch_array($result))
{
  $itemID = $row['itemID'];
}

$insertReservationSQL = "INSERT INTO Reservation (userName, itemID, status)
VALUES (?, ?, 'Pending');";

if($stmt = mysqli_prepare($dbCon, $insertReservationSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "ss", $paramUserName, $paramItemID);
  #Set parameters
  $currentDate = date('Y-m-d');
  $paramUserName = $_SESSION['username'];
  $paramItemID = trim($itemID);
  #Attempt to execute prepared statement
  if(mysqli_stmt_execute($stmt)) {
    #Redirect to view all items page --- might change this later to go to the product page itself, but it doesn't exist yet
    header("location: ../servicesParts/viewReservation.php?reservationID=" . mysqli_insert_id($dbCon));
  } else {
    echo "Oops! Something went wrong. Please try again later. :)";
  }
  #Close statement
  mysqli_stmt_close($stmt);
}
mysqli_close($dbCon);
?>