<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
<?php
	require_once "../database/config.php";

$result = mysqli_query($dbCon,"SELECT * FROM ProductType WHERE ProductName='" . $_GET["productName"] . "';");

while($row = mysqli_fetch_array($result))
{

  echo "<!--Section 1-->
  <div class=\"section1\">
    <div>
      <h1 class=\"title\">View type " . $row['productName'] . "</h1>
    </div>
  </div>
  <!--Section 2-->
  <section>
  </section>
  <!--Section 3-->
  <section>";



  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Product Name</label>
  <p>" . $row['productName'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Product Link</label>
  <p>" . $row['productLink'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Stock Count</label>
  <p>" . $row['stockCount'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Reusable</label>
  <p>" . $row['reusable'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Image Link</label>
  <p>" . $row['imageLink'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Request Period</label>
  <p>" . $row['requestPeriod'] . "</p>
  </div>";
}

?>

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









<?php

$result = mysqli_query($dbCon,"SELECT * FROM Item WHERE ProductName = '" . $_GET["productName"] . "';");

echo "<table id=\"itemTable\">
<tr>
<th>Product Name</th>
<th>Index</th>
<th>Comments</th>
<th>In Stock</th>
</tr>";
$index = 0;

while($row = mysqli_fetch_array($result))
{
  $index = $index + 1;
  echo "<tr>";
  echo "<td>" . $row['productName'] . "</td>";
  echo "<td>" . $index . "</td>";
  echo "<td>" . $row['comments'] . "</td>";
  echo "<td>" . $row['inStock'] . "</td>";
  echo "</tr>";
}
mysqli_close($dbCon);
?>
      </table>

    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
