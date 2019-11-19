<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
<?php
	require_once "../database/config.php";

$result = mysqli_query($dbCon,"SELECT * FROM Reservation LEFT JOIN Item on Reservation.itemID=Item.itemID WHERE reservationID='" . $_GET["reservationID"] . "';");

while($row = mysqli_fetch_array($result))
{

  echo "<!--Section 1-->
  <div class=\"section1\">
    <div>
      <h1 class=\"title\">View Reservation</h1>
    </div>
  </div>
  <!--Section 2-->
  <section>
  </section>
  <!--Section 3-->
  <section>";



  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>User Name</label>
  <p>" . $row['userName'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Date In</label>
  <p>" . $row['dateIn'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Date Out</label>
  <p>" . $row['dateOut'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Product Name</label>
  <p><a href=\"../servicesParts/viewProductType.php?productName=" . $row['productName'] . "\">" . $row['productName'] . "</a></p>
  </div>";
  if($row['status'] != 'Pending')
  {
    echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
    <label>Item Name</label>
    <p><a href=\"../servicesParts/viewItem.php?itemID=" . $row['itemID'] . "\">" . $row['itemName'] . "</a></p>
    </div>";
  }
  else
  {
    echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
    <label>Item Name</label>
    <p></p>
    </div>";
  }
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Expected Return Date</label>
  <p>" . $row['expectedReturnDate'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Status</label>
  <p>" . $row['status'] . "</p>
  </div>";
  $_SESSION['status'] = $row['status'];
  $_SESSION['itemID'] = $row['itemID'];
}

?>

<section style="text-align: center; margin: 15px;">
  <?php if (isset($_SESSION["isAdmin"])) {echo (($_SESSION["isAdmin"]) ?
        "<a type=\"button\" class=\"btn btn-warning\" href=\"../adminParts/editReservation.php?reservationID=" . $_GET['reservationID'] . "\">Edit Reservation</a>\n" : "");} ?>
  <?php
    if(isset($_SESSION["isAdmin"]))
    {
      if($_SESSION['status'] == 'Pending')
      {
        echo "<a type=\"button\" class=\"btn btn-success\" href=\"../adminParts/chooseItem.php?reservationID=" . $_GET['reservationID'] . "\">Accept Reservation</a>\n";
        echo "<a type=\"button\" class=\"btn btn-danger\" href=\"../adminParts/declineReservation.php?reservationID=" . $_GET['reservationID'] . "\">Decline Reservation</a>\n";
      }
      if($_SESSION['status'] == 'Accepted')
      {
        $query = "SELECT * FROM Reservation LEFT JOIN Item on Reservation.itemID=Item.itemID WHERE Item.itemID='" . $_SESSION["itemID"] . "' AND Reservation.status='Checked Out';";
        $result = mysqli_query($dbCon, $query);
        if(mysqli_num_rows($result) == 0)
        {
          echo "<a type=\"button\" class=\"btn btn-primary\" href=\"../adminParts/checkOut.php?reservationID=" . $_GET['reservationID'] . "\">Check Out</a>\n";
        }
        echo "<a type=\"button\" class=\"btn btn-danger\" href=\"../adminParts/declineReservation.php?reservationID=" . $_GET['reservationID'] . "\">Decline Reservation</a>\n";
      }
      if($_SESSION['status'] == 'Checked Out')
      {
        echo "<a type=\"button\" class=\"btn btn-primary\" href=\"../adminParts/checkIn.php?reservationID=" . $_GET['reservationID'] . "\">Check In</a>\n";
      }
      if($_SESSION['status'] == 'Declined')
      {
        echo "<a type=\"button\" class=\"btn btn-success\" href=\"../adminParts/chooseItem.php?reservationID=" . $_GET['reservationID'] . "\">Accept Reservation</a>\n";
        echo "<a type=\"button\" class=\"btn \" style=\"background-color:black; color:white;\" href=\"../adminParts/terminateReservation.php?reservationID=" . $_GET['reservationID'] . "\">Terminate Reservation</a>\n";
      }
    }
  ?>
</section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
