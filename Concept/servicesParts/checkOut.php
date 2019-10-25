<?php require "../sharedParts/header.php"; ?>
<?php
	require_once "../database/config.php";

$productNameSQL = "UPDATE Item SET inStock=0 WHERE itemID=?;";
echo $productNameSQL;

if($stmt = mysqli_prepare($dbCon, $productNameSQL)) {
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
?>