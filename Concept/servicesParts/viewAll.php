<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Products List</h1>
        <p>
          This is where you will be able to view all products.
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
<th>Product Link</th>
<th>Stock Count</th>
<th>Reusable</th>
<th>Image Link</th>
<th>Product Name</th>
<th>Request Period</th>
<th>Operations</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td><a href=\"viewProductType.php?productName=" . $row['productName'] . "\">" . $row['productLink'] . "</a></td>";
echo "<td>" . $row['stockCount'] . "</td>";
echo "<td>" . $row['reusable'] . "</td>";
echo "<td>" . $row['imageLink'] . "</td>";
echo "<td>" . $row['productName'] . "</td>";
echo "<td>" . $row['requestPeriod'] . "</td>";
echo "<td><a type=\"button\" class=\"btn btn-success\" href=\"../adminParts/addItem.php?productName=" . $row['productName'] . "\">Add</a>
<a type=\"button\" class=\"btn btn-warning\">Edit</a></td>";
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
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
