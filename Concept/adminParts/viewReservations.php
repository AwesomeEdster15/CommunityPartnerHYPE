<?php require "../sharedParts/header.php";

if (!isset($_SESSION["isAdmin"]) && !isset($_GET['userName']))
{
	header("Location: ../accountParts/login.php");
}

?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Reservations</h1>
        <p>
          This is where you will be able to view reservations.
        </p>
      </div>
    </div>
    <!--Section 2-->
    <section>
        <input type="text" id="searchBar" onkeyup="search()" placeholder="Filter items...">
    </section>
    <!--Section 3-->
    <section>
<?php
  require_once "../database/config.php";

  $selectString = "";

  if(isset($_GET["userName"]) == false)
  {
    $selectString = "SELECT * FROM Reservation LEFT JOIN Item on Reservation.itemID=Item.itemID;";
  }
  else
  {
    $selectString = "SELECT * FROM Reservation LEFT JOIN Item on Reservation.itemID=Item.itemID WHERE Reservation.userName = '" . $_GET['userName'] . "';";
  }

$result = mysqli_query($dbCon, $selectString);

echo "<table id=\"itemTable\">
<tr>
<th onclick=\"sortTable(0) \" style=\"cursor: pointer;\">User Name</th>
<th onclick=\"sortTable(1) \" style=\"cursor: pointer;\">Product Name</th>
<th onclick=\"sortTable(2) \" style=\"cursor: pointer;\">Item Name</th>
<th onclick=\"sortTable(3) \" style=\"cursor: pointer;\">Date In</th>
<th onclick=\"sortTable(4) \" style=\"cursor: pointer;\">Date Out</th>
<th onclick=\"sortTable(5) \" style=\"cursor: pointer;\">Expected Return Date</th>
<th onclick=\"sortTable(6) \" style=\"cursor: pointer;\">Status</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['userName'] . "</td>";
echo "<td><a href=\"../servicesParts/viewProductType.php?productName=" . $row['productName'] . "\">" . $row['productName'] . "</a></td>";
if($row['status'] != 'Pending')
{
  echo "<td><a href=\"../servicesParts/viewItem.php?itemID=" . $row['itemID'] . "\">" . $row['itemName'] . "</a></td>";
}
else
{
  echo "<td></td>";
}
echo "<td>" . $row['dateIn'] . "</td>";
echo "<td>" . $row['dateOut'] . "</td>";
echo "<td>" . $row['expectedReturnDate'] . "</td>";
echo "<td><a href=\"../servicesParts/viewReservation.php?reservationID=" . $row['reservationID'] . "\">" . $row['status'] . "</a></td>";
echo "</tr>";
}

mysqli_close($dbCon);
?>
</table>

        <script>
          function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("itemTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
              td = tr[i].getElementsByTagName("td")[0];
              if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  tr[i].style.display = "";
                } else {
                  tr[i].style.display = "none";
                }
              }
            }
          }

          function sortTable(n) {
              var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
              table = document.getElementById("itemTable");
              switching = true;
              // Set the sorting direction to ascending:
              dir = "asc";
              /* Make a loop that will continue until
              no switching has been done: */
              while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                  // Start by saying there should be no switching:
                  shouldSwitch = false;
                  /* Get the two elements you want to compare,
                  one from current row and one from the next: */
                  x = rows[i].getElementsByTagName("td")[n];
                  y = rows[i + 1].getElementsByTagName("td")[n];
                  /* Check if the two rows should switch place,
                  based on the direction, asc or desc: */
                  if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch = true;
                      break;
                    }
                  } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch = true;
                      break;
                    }
                  }
                }
                if (shouldSwitch) {
                  /* If a switch has been marked, make the switch
                  and mark that a switch has been done: */
                  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                  switching = true;
                  // Each time a switch is done, increase this count by 1:
                  switchcount ++;
                } else {
                  /* If no switching has been done AND the direction is "asc",
                  set the direction to "desc" and run the while loop again. */
                  if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                  }
                }
              }
            }
         </script>
    </section>
    <section style="text-align: center; margin: 15px;">
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
