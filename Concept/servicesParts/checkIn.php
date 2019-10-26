<?php require "../sharedParts/header.php"; ?>
<?php
	require_once "../database/config.php";

$updateInStockSQL = "UPDATE Item SET inStock=1 WHERE itemID=?;";
echo $productNameSQL;

if($stmt = mysqli_prepare($dbCon, $updateInStockSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "s", $paramItemID);
  #Set parameters
  $paramItemID = trim($_GET['itemID']);
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

$result = mysqli_query($dbCon,"SELECT * FROM Reservation WHERE itemID=" . trim($_GET['itemID']) . " ORDER BY dateIn DESC;");
while($row = mysqli_fetch_array($result))
{
  $reservationID = $row['reservationID'];
}
echo $reservationID;

$updateDateInSQL = "UPDATE Reservation SET dateIn=? WHERE reservationID=?;";

if($stmt = mysqli_prepare($dbCon, $updateDateInSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "ss", $paramDateIn, $paramReservationID);
  #Set parameters
  $paramDateIn = date('Y-m-d');
  $paramReservationID = $reservationID;
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