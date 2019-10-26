<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Reservations</h1>
        <p>
          This is where you will be able to view all reservations.
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

$result = mysqli_query($dbCon,"SELECT * FROM Reservation;");

echo "<table id=\"itemTable\">
<tr>
<th>User Name</th>
<th>Date In</th>
<th>Date Out</th>
<th>Item ID</th>
<th>Expected Return Date</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['userName'] . "</td>";
echo "<td>" . $row['dateIn'] . "</td>";
echo "<td>" . $row['dateOut'] . "</td>";
echo "<td>" . $row['itemID'] . "</td>";
echo "<td>" . $row['expectedReturnDate'] . "</td>";
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
         </script>
    </section>
    <section style="text-align: center; margin: 15px;">
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
