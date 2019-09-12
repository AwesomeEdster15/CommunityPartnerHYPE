<?php
#Register Page
#Equipment Loan WebApp
#Copyright 2019
?>

<?php
  #Include config file
  require_once "config.php";

  #Define variables and initialize empty
  $username = "";
  $password = "";
  $confirmPassword = "";
  $usernameError = "";
  $passwordError = "";
  $confirmPasswordError = "";

  #Process form data after form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    #Validate Username
    if(empty(trim($_POST["username"]))) {
      $usernameError = "Please enter a username.";
    } else {
      #Prepare a SELECT statement
      $userIdSQL = "SELECT id FROM users WHERE username = ?";
      if($stmt = mysqli_prepare($dbCon, $userIdSQL)) {
        #Bind variables to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $paramUsername);
        #Set parameters
        $paramUsername = trim($_POST["username"]);
        #Attemp to execute the prepared statement
        if(mysqli_stmt_execute($stmt))  {
          #Store the result
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1) {
            $usernameError = "This username is taken.";
          } else {
            $username = trim($_POST["username"]);
          }
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      #Close statement
      mysqli_stmt_close($stmt);
    }
    #Validate Password
    if(empty(trim($_POST["password"]))) {
      $passwordError = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 8) {
      $passwordError = "Password must be at least 8 characters.";
    } else {
      $password = trim($_POST["password"]);
    }
    #Validate confirm Password
    if(empty(trim($_POST["confirmPassword"]))) {
      $confirmPasswordError = "Please confirm password.";
    } else {
      $confirmPassword = trim($_POST["confirmPassword"]);
      if(empty($passwordError) && ($password != $confirmPassword)) {
        $confirmPasswordError = "Passwords do not match.";
      }
    }
    #Check input errors before inserting into database
    if(empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
      #Prepare an insert statement
      $insertUserSQL = "INSERT INTO users (username, password) VALUES (?, ?)";
      if($stmt = mysqli_prepare($dbCon, $insertUserSQL)) {
        #Bind variables to statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $paramUsername, $paramPassword);
        #Set parameters
        $paramUsername = $username;
        #Hash password for storage
        $paramPassword = password_hash($password, PASSWORD_DEFAULT);
        #Execute prepared statment
        if(mysqli_stmt_execute($stmt)) {
          #Redirect to Login page
          header("location: login.php");
        } else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      #Close statement
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
  <title>Register User</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body{ font:14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>Register User</h2>
    <p>Complete this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group <?php echo (!empty($usernameError)) ? 'has-error' : ''; ?>">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        <span class="help-block"><?php echo $usernameError; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($passwordError)) ? 'has-error' : ''; ?>">
        <label>Password</label>
        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $passwordError; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($confirmPasswordError)) ? 'has-error' : ''; ?>">
        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" class="form-control" value="<?php echo $confirmPassword; ?>">
        <span class="help-block"><?php echo $confirmPasswordError; ?></span>
      </div>
      <div clas="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
        <input type="reset" class="btn btn-default" value="Reset">
      </div>
      <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
  </body>
  </html>
