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
<th>Image Link</th>
<th>Product Name</th>
<th>Product Link</th>
<th>Stock Count</th>
<th>Reusable</th>
<th>Request Period</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
$image = $row['imageLink'];
echo "<td> <img src=\"$image\" width=\"100\" height=\"100\" /> </td>";
echo "<td>" . $row['productName'] . "</td>";
echo "<td>" . $row['productLink'] . "</td>";
echo "<td>" . $row['stockCount'] . "</td>";
//echo "<td>" . $row['imageLink'] . "</td>";
echo "<td>" . $row['reusable'] . "</td>";
echo "<td>" . $row['requestPeriod'] . "</td>";
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
         </script>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
