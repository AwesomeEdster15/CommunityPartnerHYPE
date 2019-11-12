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
$dateIn = "";
$dateOut = "";
$expectedReturnDate = "";

$expectedReturnDateError = "";

#Process Form data after form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
$expectedReturnDate = "";
  if(empty(trim($_POST["expectedReturnDate"]))) {
    $expectedReturnDateError = "Please enter expected return date.";
  } else {
    $expectedReturnDate = trim($_POST["expectedReturnDate"]);
  }
  $dateOut = trim($_POST["dateOut"]);
  $dateIn = trim($_POST["dateIn"]);

  #Check input errors before inserting into database
  if(empty($expectedReturnDateError)) {
    #Prepare an insert statement
    $insertItemSQL = "UPDATE Reservation SET dateIn=?, dateOut=?, expectedReturnDate=? WHERE reservationID=" . $_SESSION['reservationID'] . ";";
    if($stmt = mysqli_prepare($dbCon, $insertItemSQL)) {
      #Bind variables to statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $paramDateIn, $paramDateOut, $paramExpectedReturnDate);
      #Set parameters
      $paramDateIn = $dateIn;
      $paramDateOut = $dateOut;
      $paramExpectedReturnDate = $expectedReturnDate;
      #Execute prepared statment
      if(mysqli_stmt_execute($stmt)) {
        #Redirect to view all items page --- might change this later to go to the product page itself, but it doesn't exist yet
        header("location: ../servicesParts/viewReservation.php?reservationID=" . $_SESSION['reservationID']);
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
  $result = mysqli_query($dbCon,"SELECT * FROM Reservation WHERE reservationID='" . $_GET['reservationID'] . "';");
  while($row = mysqli_fetch_array($result))
  {
    $dateIn = $row['dateIn'];
    $dateOut = $row['dateOut'];
    $expectedReturnDate = $row['expectedReturnDate'];
    $_SESSION['reservationID'] = $_GET['reservationID'];
  }
}

?>
<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h2>Edit Item</h2>
        <p>Complete this form to add a product type</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group" style="width: 350px; display: inline-block;">
            <label>Date In</label>
            <input type="date" name="dateIn" class="form-control" value="<?php echo $dateIn; ?>">
          </div>
          <div class="form-group" style="width: 350px; display: inline-block;">
            <label>Date Out</label>
            <input type="date" name="dateOut" class="form-control" value="<?php echo $dateOut; ?>">
          </div>
          <div class="form-group" style="width: 350px; display: inline-block;">
            <label>Expected Return Date</label>
            <input type="date" name="expectedReturnDate" class="form-control" value="<?php echo $expectedReturnDate; ?>">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
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
