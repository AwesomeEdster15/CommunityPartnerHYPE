
<!--Header-->
<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <?php
        if(!isset($_SESSION["loggedin"])) {
          include "../accountParts/notLoggedIn.php";
        }
        else {
          include "../accountParts/accountInfo.php";
        }
       ?>
    </div>
    <!--Section 2-->
    <section>
    </section>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
