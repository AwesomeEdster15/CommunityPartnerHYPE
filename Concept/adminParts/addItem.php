<?php
#Add Product Type Page
#<!--Initialize Session-->
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["isAdmin"]))
{
	  header("Location: ../accountParts/login.php");
}


#Include Config File
require_once "../database/config.php";

#Define variables as Empty
$itemName = "";
$comments = "";
$inStock = "";

$itemNameError = "";
$commentsError = "";
$inStockError = "";

#Process Form data after form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty(trim($_POST["itemName"]))) {
    $itemNameError = "Please enter item name.";
  } else {
    $itemName = trim($_POST["itemName"]);
  }
  $comments = trim($_POST["comments"]);

  if(empty(trim($_POST["inStock"]))) {
    $inStockError = "Please specify if this item is in stock.";
  } else {
    $inStock = trim($_POST["inStock"]);
  }

  #Check input errors before inserting into database
  if(empty($itemNameError) && empty($inStockError)) {
    #Prepare an insert statement
    $insertItemSQL = "INSERT INTO Item (itemName, comments, productName, inStock) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($dbCon, $insertItemSQL)) {
      #Bind variables to statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $paramItemName, $paramComments, $paramProductName, $paramInStock);
      #Set parameters
      $paramItemName = $itemName;
      $paramComments = $comments;
      $paramProductName = $_SESSION['product_name'];
      $paramInStock = $inStock;
      #Execute prepared statment
      if(mysqli_stmt_execute($stmt)) {
        #Redirect to view all items page --- might change this later to go to the product page itself, but it doesn't exist yet
        header("location: ../servicesParts/viewProductType.php?productName=" . $_SESSION['product_name']);
      } else {
        echo "Oops! Something went wrong. Please try again later. :)";
      }
      #Close statement
      mysqli_stmt_close($stmt);
    }
  }
  #Close connection
  mysqli_close($dbCon);
}
else
{
  $_SESSION['product_name'] = $_GET['productName'];
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Capable Kids and Families</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
  <!------------>
  <!---HEADER--->
  <!------------>
  <div class="header">
    <!--Logo and Navigation Buttons-->
    <div>
      <!--Logo-->
      <div>
        <img src="../imgs/CKF-Logo.png" />
      </div>
      <!--Navigation Buttons-->
    </div>
  </div>
  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h2>Add <?php echo $_GET['productName'] ?> Item</h2>
        <p>Complete this form to add a product type</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($itemName)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Item Name</label>
            <input type="text" name="itemName" class="form-control" value="<?php echo $itemName; ?>">
            <span class="help-block"><?php echo $itemNameError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($inStockError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Is In Stock</label>
            <select list="TrueFalse" name="inStock" class="form-control" value="<?php echo $inStock; ?>">
              <option value="1">Yes</option>
              <option value="00">No</option>
            </select>
            <span class="help-block"><?php echo $inStockError; ?></span>
          </div>
          <div class="form-group" style="width: 350px;">
            <label>Comments</label>
            <textarea name="comments" class="form-control" value="<?php echo $comments; ?>" style="display: inline-block; vertical-align: top;"></textarea>
            <span class="help-block"><?php echo $commentsError; ?></span>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
          </div>
          <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
      </div>
      <!--Section 2-->
      <section>
      </section>
      <!--Section 3-->
      <section>
      </section>
    </div>
  </div>
</body>
</html>
<!---FOOTER--->
<?php #require "../sharedParts/footer.php"; ?>
