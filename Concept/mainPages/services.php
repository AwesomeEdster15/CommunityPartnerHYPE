<?php if (!isset($_SESSION)) session_start(); ?>

<!--Header-->
<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Hello!</h1>
        <p>
          This is where you can View all the services that we Provide!
        </p>
      </div>
    </div>
    <!--Section 2-->
    <div style="text-align: center">
    <p id='services'> <input type="button" onclick="window.location.href = '../servicesParts/viewAll.php';" value="View All Products"/>
    <div class="section1">
      <?php if (isset($_SESSION["isAdmin"])) {echo (($_SESSION["isAdmin"]) ? "<p id='services'> <input type=\"button\" onclick=\"window.location.href = '../adminParts/viewReservations.php';\" value=\"View All Reservations\"/> </p>" : ''); } ?>
    </div>
    <div class="section1">
      <?php if (isset($_SESSION["loggedin"])) {echo (($_SESSION["loggedin"]) ? "<p id='services'> <input type=\"button\" onclick=\"window.location.href = '../adminParts/viewReservations.php?userName=" . $_SESSION["username"] . "';\" value=\"View My Reservations\"/>" : ''); } ?>
    </div>
  </div>
    </p>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
