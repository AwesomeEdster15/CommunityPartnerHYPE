<?php
#Login Page
#Equipment Loan WebApp
#Copyright 2019
?>

<?php
#Initialize the Session
session_start();

#Check if user is logged in, if yes redirect to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome.php");
  exit;
}

#Include config file
require_once "config.php";
#Define variables and initialize empty
$username = "";
$password = "";
$usernameError = "";
$passwordError = "";

#processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  #Check if username is empty
  if(empty(trim($_POST["username"]))) {
    $usernameError = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }
  #Check if password is empty
  if(empty(trim($_POST["password"]))) {
    $passwordError = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  #Validate Credentials
  if(empty($usernameError) && empty($passwordError)) {
    #Prepare select statement
    $userValSQL = "SELECT id, username, password FROM users WHERE username = ?";
    if($stmt = mysqli_prepare($dbCon, $userValSQL)) {
      #Bind variables to statment as parameters
      mysqli_stmt_bind_param($stmt, "s", $paramUsername);
      #Set parameters
      $paramUsername = $username;
      #Execute prepared statment
      if(mysqli_stmt_execute($stmt)) {
        #Store result
        mysqli_stmt_store_result($stmt);
        #Check if Username Exists, then verify password
        if(mysqli_stmt_num_rows($stmt) == 1) {
          #Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashedPassword);
          if(mysqli_stmt_fetch($stmt)) {
            if(password_verify($password, $hashedPassword)) {
              #Password is correct, start new sesion
              session_start();
              #Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              #Redirect user to welcome page
              header("location: welcome.php");
            } else {
              #Error message if password is not valid
              $passwordError = "Password is invalid.";
            }
          }
        } else {
          #Error message if user name does not exist
          $usernameError = "User does not exist.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again.";
      }
    }
    #Close statment
    mysqli_stmt_close($stmt);
  }
  #Close connection
  mysqli_close($dbCon);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body{ font: 14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <p>Enter your Username and Password to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group <?php echo (!empty($usernameError)) ? 'has-error' : ''; ?>">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        <span class="help-block"><?php echo $usernameError; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($passwordError)) ? 'has-error' : ''; ?>">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        <span class="help-block"><?php echo $passwordError; ?></span>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Login">
      </div>
      <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
  </div>
</body>
</html>
