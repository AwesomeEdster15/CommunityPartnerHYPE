<?php require "../sharedParts/header.php"; ?>
<?php
  require_once "../database/config.php";
  
$itemID = "";
$result = mysqli_query($dbCon,"SELECT itemID FROM Reservation WHERE reservationID=" . trim($_GET['reservationID']) . ";");
while($row = mysqli_fetch_array($result))
{
  $itemID = $row['itemID'];
}
echo $itemID;

$updateInStockSQL = "UPDATE Item SET inStock=1 WHERE itemID=?;";

if($stmt = mysqli_prepare($dbCon, $updateInStockSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "s", $paramItemID);
  #Set parameters
  $paramItemID = trim($itemID);
  #Attempt to execute prepared statement
  if(mysqli_stmt_execute($stmt) == false) {
    echo "Oops! Something went wrong. Please try again later. :)";
  }
  #Close statement
  mysqli_stmt_close($stmt);
}

$updateDateInSQL = "UPDATE Reservation SET dateIn=?, status='Completed' WHERE reservationID=" . $_GET['reservationID'] . ";";

if($stmt = mysqli_prepare($dbCon, $updateDateInSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "s", $paramDateIn);
  #Set parameters
  $paramDateIn = date('Y-m-d');
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