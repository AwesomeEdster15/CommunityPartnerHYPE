<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
<?php
	require_once "../database/config.php";

$result = mysqli_query($dbCon,"SELECT * FROM Item WHERE itemID='" . $_GET['itemID'] . "';");


while($row = mysqli_fetch_array($result))
{
  $itemName = $row['productName'] . $row['itemID'];
  $itemID = $row['itemID'];
  echo "<!--Section 1-->
  <div class=\"section1\">
    <div>
      <h1 class=\"title\">View " . $itemName . "</h1>
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
  <label>Comments</label>
  <p>" . $row['comments'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Is In Stock</label>
  <p>" . $row['inStock'] . "</p>
  </div>";

  echo "<section style=\"text-align: center;\">
  <a type=\"button\" class=\"btn btn-warning\" style=\"margin: 15px;\">Edit " . $itemName . "</a>";
  if($row['inStock'] == true)
  {
    echo "<td><a class=\"btn btn-primary\" href=\"checkOut.php?itemID=" . $itemID . "\">Check Out</a></td>";
  }
  else
  {
    echo "<td><a class=\"btn btn-primary\" href=\"checkIn.php?itemID=" . $itemID . "\">Check In</a></td>";
  }
  echo "</section>";
}
mysqli_close($dbCon);

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

    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
