<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Products List</h1>
        <p>
          This is where you can view all of our Products. <br>
          Click the column headers to sort the table or use the search field to search by Product Name.
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

            $result = mysqli_query($dbCon,"SELECT * FROM ProductType");

            echo "<table id=\"itemTable\">
            <tr>
            <th>Image Link</th>
            <th onclick=\"sortTable(1) \" style=\"cursor: pointer;\">Product Name</th>
            <th onclick=\"sortTable(2) \" style=\"cursor: pointer;\">Stock Count</th>
            <th onclick=\"sortTable(3) \" style=\"cursor: pointer;\">Reusable</th>
            <th onclick=\"sortTable(4) \" style=\"cursor: pointer;\">Request Period</th>
            <th onclick=\"sortTable(5) \" style=\"cursor: pointer;\">Keyword</th>
            </tr>";

            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                $image = $row['imageLink'];
                $product = $row['productLink'];
                echo "<td> <a href=\"$product\"><img src=\"$image\" width=\"100\" height=\"100\" /></a> </td>";
                echo "<td><a href=\"viewProductType.php?productName=" . $row['productName'] . "\">" . $row['productName'] . "</a></td>";
                echo "<td>" . $row['stockCount'] . "</td>";
                echo "<td>" . $row['reusable'] . "</td>";
                echo "<td>" . $row['requestPeriod'] . "</td>";
                echo "<td>" . $row['productKeyword'] . "</td>";
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
              td = tr[i].getElementsByTagName("td")[1];
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
    <section style="text-align: center; padding: 15px 0px 15px 0px;">
        <?php if (isset($_SESSION["isAdmin"])) {echo (($_SESSION["isAdmin"]) ? "<a type=\"button\" class=\"btn btn-success\" href=\"../adminParts/addProductType.php\">Add Product Type</a>" : "");} ?>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
