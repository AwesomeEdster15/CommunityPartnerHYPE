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
    <div class="section1">
        <?php if (isset($_SESSION["isAdmin"])) {echo (($_SESSION["isAdmin"]) ? "<p id='services'> <input type=\"button\" onclick=\"window.location.href = '../servicesParts/viewAll.php';\" value=\"View All Products\"/> </p>" : 'IT WORKED'); } ?>
    </div>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
