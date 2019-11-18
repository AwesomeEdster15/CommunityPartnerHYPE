<?php require "../sharedParts/header.php"; ?>
<?php
  require_once "../database/config.php";

  if (!isset($_SESSION["isAdmin"]))
  {
  	header("Location: ../accountParts/login.php");
  }
    
$itemID = "";
$result = mysqli_query($dbCon,"SELECT itemID FROM Reservation WHERE reservationID=" . trim($_GET['reservationID']) . ";");
while($row = mysqli_fetch_array($result))
{
  $itemID = $row['itemID'];
}
echo $itemID;


$updateInStockSQL = "UPDATE Item SET inStock=0 WHERE itemID=?;";
echo $updateInStockSQL;

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

$productName = "";
$requestPeriod = "";

$result = mysqli_query($dbCon,"SELECT productName FROM Item WHERE itemID=" . trim($itemID) . ";");
while($row = mysqli_fetch_array($result))
{
  $productName = $row['productName'];
}
echo $productName;

$result = mysqli_query($dbCon,"SELECT requestPeriod FROM ProductType WHERE productName='" . $productName . "';");
while($row = mysqli_fetch_array($result))
{
  $requestPeriod = $row['requestPeriod'];
}
echo $requestPeriod;

$updateReservationSQL = "UPDATE Reservation SET dateOut=?, expectedReturnDate=?, status='Checked Out' WHERE reservationID=" . trim($_GET['reservationID']) . ";";
echo $updateReservationSQL;

if($stmt = mysqli_prepare($dbCon, $updateReservationSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "ss", $paramDateOut, $paramExpectedReturnDate);
  #Set parameters
  $currentDate = date('Y-m-d');
  $paramUserName = $_SESSION['username'];
  $paramDateOut = $currentDate;
  $paramExpectedReturnDate = date('Y-m-d', strtotime($currentDate . " + " . $requestPeriod . " days"));
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
