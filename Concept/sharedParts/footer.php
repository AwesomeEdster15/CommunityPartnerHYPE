<div class="footer1">
  <div>
    <?php
      if(!isset($_SESSION["loggedin"])) {
        echo "<p style=\"text-align: center;\">
          <a href=\"../accountParts/login.php\" class=\"btn btn-danger\">Sign In</a>
        </p>";
      }
      else {
        echo "<p style=\"text-align: center;\">
          <a href=\"../accountParts/logout.php\" class=\"btn btn-danger\">Sign Out</a>
        </p>";
      }
     ?>
  </div>
</div>
</body>
</html>
