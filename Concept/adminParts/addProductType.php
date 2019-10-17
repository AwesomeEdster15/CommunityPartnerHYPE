<?php
#Add Product Type Page
#<!--Initialize Session-->
if (!isset($_SESSION)) session_start();

#Include Config File
require_once "../database/config.php";

#Define variables as Empty
$productLink = "";
$stockCount = "";
$reusable = "";
$imageLink = "";
$productName = "";
$requestPeriod = "";

$productLinkError = "";
$stockCountError = "";
$reusableError = "";
$imageLinkError = "";
$productNameError = "";
$requestPeriodError = "";

#Process Form data after form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  #Validate productName
  if(empty(trim($_POST["productName"]))) {
    $productLinkError = "Please enter a product name.";
  } else {
    #Prepare SELECT statement
    $productNameSQL = "SELECT productName FROM ProductType WHERE productName = ?";
    if($stmt = mysqli_prepare($dbCon, $productNameSQL)) {
      #Bind variables to prepared statement
      mysqli_stmt_bind_param($stmt, "s", $paramProductName);
      #Set parameters
      $paramProductName = trim($_POST["productName"]);
      #Attempt to execute prepared statement
      if(mysqli_stmt_execute($stmt)) {
        #Store result
        mysqli_stmt_store_result($stmt);
        #If the statement reutrns exactly 1 row
        if(mysqli_stmt_num_rows($stmt) == 1) {
          $productName = "This product type already exists.";
        } else {
          $productName = trim($_POST["productName"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later...";
      }
      #Close statment
      mysqli_stmt_close($stmt);
    }
  }
  if(empty(trim($_POST["stockCount"]))) {
    $stockCountError = "Please enter the number of items available.";
  } else {
    $stockCount = trim($_POST["stockCount"]);
  }
  if(empty(trim($_POST["reusable"]))) {
    $reusableError = "Please specify if this item is reusable.";
  } else {
    $reusable = trim($_POST["reusable"]);
  }
  if(empty(trim($_POST["productLink"]))) {
    $productLinkError = "Please enter a product link.";
  } else {
    $productLink = trim($_POST["productLink"]);
  }
  if(empty(trim($_POST["imageLink"]))) {
    $imageLinkError = "Please enter the image URL.";
  } else {
    $imageLink = trim($_POST["imageLink"]);
  }
  if(empty(trim($_POST["productName"]))) {
    $productNameError = "Please enter an product name.";
  } else {
    $productName = trim($_POST["productName"]);
  }
	if(empty(trim($_POST["requestPeriod"]))) {
	  $requestPeriodError = "Please enter request period.";
  } else {
    $requestPeriod = trim($_POST["requestPeriod"]);
  }

  #Check input errors before inserting into database
  if(empty($stockCountError) && empty($reusableError) && empty($imageLinkError) && empty($productNameError) && empty($requestPeriodError) && empty($productLinkError)) {
    #Prepare an insert statement
    $insertProductTypeSQL = "INSERT INTO ProductType (productLink, stockCount, reusable, imageLink, productName, requestPeriod) VALUES (?, ?, ?, ?, ?, ?)";
    if($stmt = mysqli_prepare($dbCon, $insertProductTypeSQL)) {
      #Bind variables to statement as parameters
      mysqli_stmt_bind_param($stmt, "sisssi", $paramproductLink, $paramStockCount, $paramReusable, $paramImageLink, $paramProductName, $paramRequestPeriod);
      #Set parameters
      $paramproductLink = $productLink;
      $paramStockCount = $stockCount;
      $paramReusable = $reusable;
      $paramImageLink = $imageLink;
      $paramProductName = $productName;
      $paramRequestPeriod = $requestPeriod;
      #Execute prepared statment
      if(mysqli_stmt_execute($stmt)) {
        #Redirect to view all items page --- might change this later to go to the product page itself, but it doesn't exist yet
        header("location: ../servicesParts/viewAll.php");
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
        <h2>Add Product Type</h2>
        <p>Complete this form to add a product type</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($productNameError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Product Name</label>
            <input type="text" name="productName" class="form-control" value="<?php echo $productName; ?>">
            <span class="help-block"><?php echo $productNameError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($productLinkError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Product Link</label>
            <input type="text" name="productLink" class="form-control" value="<?php echo $productLink; ?>">
            <span class="help-block"><?php echo $productLinkError; ?></span>
          </div>
          <br>
          <div class="form-group <?php echo (!empty($stockCountError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Stock Count</label>
            <input type="text" name="stockCount" maxlength="2" class="form-control" value="<?php echo $stockCount; ?>">
            <span class="help-block"><?php echo $stockCountError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($reusableError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Reusable</label>
            <select list="TrueFalse" name="reusable" class="form-control" value="<?php echo $reusable; ?>">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
            <span class="help-block"><?php echo $reusableError; ?></span>
          </div>
          <br>
          <div class="form-group <?php echo (!empty($imageLinkError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Image Link</label>
            <input type="text" name="imageLink" class="form-control" value="<?php echo $imageLink; ?>">
            <span class="help-block"><?php echo $imageLinkError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($requestPeriodError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Request Period (Number of Days)</label>
            <input type="text" name="requestPeriod" class="form-control" value="<?php echo $requestPeriod; ?>">
            <span class="help-block"><?php echo $requestPeriodError; ?></span>
          </div>
          <div clas="form-group">
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
