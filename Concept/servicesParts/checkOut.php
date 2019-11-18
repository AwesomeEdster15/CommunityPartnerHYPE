<?php require "../sharedParts/header.php"; ?>
<?php
	require_once "../database/config.php";

	if (!isset($_SESSION["isAdmin"]))
	{
		header("Location: ../accountParts/login.php");
	}
	
$updateInStockSQL = "UPDATE Item SET inStock=0 WHERE itemID=?;";
echo $updateInStockSQL;

if($stmt = mysqli_prepare($dbCon, $updateInStockSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "s", $paramItemID);
  #Set parameters
  $paramItemID = trim($_GET['itemID']);
  #Attempt to execute prepared statement
  if(mysqli_stmt_execute($stmt) == false) {
    echo "Oops! Something went wrong. Please try again later. :)";
  }
  #Close statement
  mysqli_stmt_close($stmt);
}

$productName = "";
$requestPeriod = "";

$result = mysqli_query($dbCon,"SELECT productName FROM Item WHERE itemID=" . trim($_GET['itemID']) . ";");
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

$insertReservationSQL = "INSERT INTO Reservation (userName, dateOut, itemID, expectedReturnDate)
VALUES (?, ?, ?, ?);";
echo $insertReservationSQL;

if($stmt = mysqli_prepare($dbCon, $insertReservationSQL)) {
  #Bind variables to prepared statement
  mysqli_stmt_bind_param($stmt, "ssss", $paramUserName, $paramDateIn, $paramItemID, $paramExpectedReturnDate);
  #Set parameters
  $currentDate = date('Y-m-d');
  $paramUserName = $_SESSION['username'];
  $paramDateIn = $currentDate;
  $paramItemID = trim($_GET['itemID']);
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
