<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
<?php
	require_once "../database/config.php";

$result = mysqli_query($dbCon,"SELECT * FROM Item WHERE itemID='" . $_GET['itemID'] . "';");


while($row = mysqli_fetch_array($result))
{
  $itemName = $row['itemName'];
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
  <label>Item Name</label>
  <p>" . $row['itemName'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Product Name</label>
  <p><a href=\"viewProductType.php?productName=" . $row['productName'] . "\">" . $row['productName'] . "</a></p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Comments</label>
  <p>" . $row['comments'] . "</p>
  </div>";
  echo "<div class=\"form-group\" style=\"width: 350px; display: inline-block;\">
  <label>Is In Stock</label>
  <p>" . $row['inStock'] . "</p>
  </div>";

  echo "<section style=\"text-align: center;\">";

  if (isset($_SESSION["isAdmin"])) {echo (($_SESSION["isAdmin"]) ?
    "<a type=\"button\" class=\"btn btn-warning\" style=\"margin: 15px;\" href=\"../adminParts/editItem.php?itemID=" . $itemID . "\">Edit " . $itemName . "</a>" : "");}
  if(isset($_SESSION['loggedin']) == true)
  {
    echo "<td><a class=\"btn btn-primary\" href=\"requestItem.php?itemID=" . $itemID . "\">Request Item</a></td>";
  }
  echo "</section>";
}
mysqli_close($dbCon);

?>


    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
