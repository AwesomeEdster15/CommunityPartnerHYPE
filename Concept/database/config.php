<?php
  #Database connection credentials
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'DB_equipmentloan');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  #Attempt to connect to database
  $dbCon = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  #Check connection
  if($dbCon === false){
    die("ERROR: Connection Not Established" . mysqli_connect_error());
  }
?>
