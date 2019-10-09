<!--Initialize Session-->
<?php if (!isset($_SESSION)) session_start(); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Capable Kids and Families</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
  <!------------>
  <!---HEADER--->
  <!------------>
  <div class="header">
    <!--Logo and Navigation Buttons-->
    <div>
      <!--Logo-->
      <div>
        <img src="../imgs/CKF-Logo.png" />
      </div>
      <!--Navigation Buttons-->
      <nav>
        <ul>
          <li><a href="../mainPages/main.php">Home</a></li>
          <li><a href="../mainPages/services.php">Services</a></li>
          <li><a href="../mainPages/aboutUs.php">About Us</a></li>
          <li><a href="../adminParts.php">Admin</a></li>
          <li><a href="../mainPages/myAccount.php"><?php echo (isset($_SESSION["username"]) ? $_SESSION["username"] : "My Account") ?></a></li>
        </ul>
      </nav>
    </div>
  </div>
