<?php require "../sharedParts/header.php"; ?>
<?php require_once "../database/config.php"; ?>
<?php

  $pendingSQL = "SELECT COUNT(reservationID) FROM Reservation WHERE status = 'Pending';";
  $pendingResult = mysqli_query($dbCon, $pendingSQL);

  $declinedSQL = "SELECT COUNT(reservationID) FROM Reservation WHERE status = 'Declined';";
  $declinedResult = mysqli_query($dbCon, $declinedSQL);

  $acceptedSQL = "SELECT COUNT(reservationID) FROM Reservation WHERE status = 'Accepted';";
  $acceptedResult = mysqli_query($dbCon, $acceptedSQL);

  $checkedOutSQL = "SELECT COUNT(reservationID) FROM Reservation WHERE status = 'Checked Out';";
  $checkedOutResult = mysqli_query($dbCon, $checkedOutSQL);
?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Capable Kids and Families</h1>
        <p>
        </p>
      </div>
    </div>
    <?php if(isset($_SESSION["isAdmin"]))
      {
        echo "<!--Section 2-->
        <script src=\"bar.js\"></script>
        <script>
            function myFunction() {
                var data = [";
                while($row = mysqli_fetch_array($pendingResult))
                {
                  echo '{label: \'Pending\'' . ', value: ' . $row['COUNT(reservationID)'] . '},
                  ';
                }

                while($row = mysqli_fetch_array($declinedResult))
                {
                  echo '{label: \'Declined\'' . ', value: ' . $row['COUNT(reservationID)'] . '},
                  ';
                }

                while($row = mysqli_fetch_array($acceptedResult))
                {
                  echo '{label: \'Accepted\'' . ', value: ' . $row['COUNT(reservationID)'] . '},
                  ';
                }

                while($row = mysqli_fetch_array($checkedOutResult))
                {
                  echo '{label: \'Checked Out\'' . ', value: ' . $row['COUNT(reservationID)'] . '},
                  ';
                }
                echo "];
                var barChart = new BarChart(\"chart\", 500, 500, data);
            }
            window.onload = function()
            {
              myFunction();
            }
        </script>

        <section style=\"text-align: center;\">
          <div id=\"chart\"></div>
          <!-- Apparently onload isn't a valid option for div tags -->
          <h3>Reservations</h3>
        </section>";
      }
    ?>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
