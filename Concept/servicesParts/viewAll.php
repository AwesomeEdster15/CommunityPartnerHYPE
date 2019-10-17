<!--Header-->
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
        <table id="itemTable">
          <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Link</th>
          </tr>
          <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td><a href="../mainPages/services.php">Germany</a></td>
          </tr>
          <tr>
            <td>Berglunds snabbköp</td>
            <td>Christina Berglund</td>
            <td><a href="../mainPages/services.php">Sweden</a></td>
          </tr>
          <tr>
            <td>Centro comercial Moctezuma</td>
            <td>Francisco Chang</td>
            <td><a href="../mainPages/services.php">Mexico</a></td>
          </tr>
          <tr>
            <td>Ernst Handel</td>
            <td>Roland Mendel</td>
            <td><a href="../mainPages/services.php">Austria</a></td>
          </tr>
          <tr>
            <td>Island Trading</td>
            <td>Helen Bennett</td>
            <td><a href="../mainPages/services.php">UK</a></td>
          </tr>
          <tr>
            <td>Königlich Essen</td>
            <td>Philip Cramer</td>
            <td><a href="../mainPages/services.php">Germany</a></td>
          </tr>
          <tr>
            <td>Laughing Bacchus Winecellars</td>
            <td>Yoshi Tannamuri</td>
            <td><a href="../mainPages/services.php">Canada</a></td>
          </tr>
          <tr>
            <td>Magazzini Alimentari Riuniti</td>
            <td>Giovanni Rovelli</td>
            <td><a href="../mainPages/services.php">Italy</a></td>
          </tr>
          <tr>
            <td>North/South</td>
            <td>Simon Crowther</td>
            <td><a href="../mainPages/services.php">UK</a></td>
          </tr>
          <tr>
            <td>Paris spécialités</td>
            <td>Marie Bertrand</td>
            <td><a href="../mainPages/services.php">France</a></td>
          </tr>
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
