<?php
#Register page
#<!--Initialize Session-->
if (!isset($_SESSION)) session_start();

#Include Config File
require_once "../database/config.php";

#Define variables as Empty
$fName = "";
$lName = "";
$username = "";
$password = "";
$confirmPassword = "";
$email = "";
$confirmEmail = "";
$phoneNumber = "";

$fNameError = "";
$lNameError = "";
$usernameError = "";
$passwordError = "";
$confirmPasswordError = "";
$emailError = "";
$confirmEmailError = "";
$phoneNumberError = "";

#Process Form data after form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  #Validate userName
  if(empty(trim($_POST["username"]))) {
    $usernameError = "Please enter a username.";
  } else {
    #Prepare SELECT statement
    $userSQL = "SELECT userName FROM patron WHERE userName = ?";
    if($stmt = mysqli_prepare($dbCon, $userSQL)) {
      #Bind variables to prepared statement
      mysqli_stmt_bind_param($stmt, "s", $paramUsername);
      #Set parameters
      $paramUsername = trim($_POST["username"]);
      #Attempt to execute prepared statement
      if(mysqli_stmt_execute($stmt)) {
        #Store result
        mysqli_stmt_store_result($stmt);
        #If the statement reutrns exactly 1 row
        if(mysqli_stmt_num_rows($stmt) == 1) {
          $usernameError = "This username is taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
    #Close statment
    mysqli_stmt_close($stmt);
  }
  #Validate First name
  if(empty(trim($_POST["firstName"]))) {
    $fNameError = "Please enter your First Name.";
  } else {
    $fName = trim($_POST["firstName"]);
  }
  #Validate Last name
  if(empty(trim($_POST["lastName"]))) {
    $lNameError = "Please enter your Last Name.";
  } else {
    $lName = trim($_POST["lastName"]);
  }
  #Validate Username
  if(empty(trim($_POST["username"]))) {
    $usernameError = "Please enter a username.";
  } else {
    $username = trim($_POST["username"]);
  }
  #Validate PhoneNumber
  if(empty(trim($_POST["phoneNumber"]))) {
    $phoneNumberError = "Please enter a phone number.";
  } else {
    $phoneNumber = trim($_POST["phoneNumber"]);
  }
  #Validate Password
  if(empty(trim($_POST["password"]))) {
    $passwordError = "Please enter a password.";
  } elseif(strlen(trim($_POST["password"])) < 8) {
    $passwordError = "Password must be at least 8 characters.";
  #} elseif (!preg_match('/^(?=[a-z])(?=[A-Z])[a-zA-Z]{8,}$/', trim($_POST["password"]))) {
    #$passwordError = "Password must contain at least 1 lowercase letter, 1 uppercase letter and 1 number.";
  } else {
    $password = trim($_POST["password"]);
  }
  #Validate confirm Password
  if(empty(trim($_POST["confirmPassword"]))) {
    $confirmPasswordError = "Please confirm password.";
  } elseif (trim($_POST["password"]) != trim($_POST["confirmPassword"])) {
    $confirmPasswordError = "Passwords do not match.";
  } else {
    $confirmPassword = trim($_POST["confirmPassword"]);
  }
  #Validate Email
  if(empty(trim($_POST["email"]))) {
    $emailError = "Please enter an email.";
  } else {
    $email = trim($_POST["email"]);
  }
  #Validate confirm Password
  if(empty(trim($_POST["confirmEmail"]))) {
    $confirmEmailError = "Please confirm email.";
  } else {
    $confirmEmail = trim($_POST["confirmEmail"]);
    if(empty($emailError) && ($email != $confirmEmail)) {
      $confirmEmailError = "Emails do not match.";
    }
  }
  #Check input errors before inserting into database
  if(empty($usernameError) && empty($passwordError) && empty($confirmPasswordError) && empty($emailError) && empty($confirmEmailError)) {
    #Prepare an insert statement
    $insertUserSQL = "INSERT INTO patron (userName, passWord, email, phoneNumber) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($dbCon, $insertUserSQL)) {
      #Bind variables to statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $paramUsername, $paramPassword, $paramEmail, $paramPhone);
      #Set parameters
      $paramUsername = $username;
      $paramEmail = $email;
      $paramPhone = $phoneNumber;
      #Hash password for storage
      $paramPassword = password_hash($password, PASSWORD_DEFAULT);
      #Execute prepared statment
      if(mysqli_stmt_execute($stmt)) {
        #Redirect to Login page
        header("location: ../mainPages/myAccount.php");
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
    </div>
  </div>
  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h2>Register User</h2>
        <p>Complete this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($fNameError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>First Name</label>
            <input type="text" name="firstName" class="form-control" value="<?php echo $fName; ?>">
            <span class="help-block"><?php echo $fNameError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($lNameError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Last Name</label>
            <input type="text" name="lastName" class="form-control" value="<?php echo $lName; ?>">
            <span class="help-block"><?php echo $lNameError; ?></span>
          </div>
          <br>
          <div class="form-group <?php echo (!empty($usernameError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $usernameError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($phoneNumberError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Phone Number (123-456-7890)</label>
            <input type="tel" placeholder="XXX-XXX-XXXX" maxlength="12" name="phoneNumber" class="form-control" value="<?php echo $phoneNumber; ?>">
            <span class="help-block"><?php echo $phoneNumberError; ?></span>
          </div>
          <br>
          <div class="form-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $emailError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirmEmailError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Confirm Email</label>
            <input type="email" name="confirmEmail" class="form-control" value="<?php echo $confirmEmail; ?>">
            <span class="help-block"><?php echo $confirmEmailError; ?></span>
          </div>
          <br>
          <div class="form-group <?php echo (!empty($passwordError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $passwordError; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirmPasswordError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
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
      </div>
      <!--Section 2-->
      <section>
      </section>
      <!--Section 3-->
      <section>
      </section>
    </div>

    <!---FOOTER--->
    <?php #require "../sharedParts/footer.php"; ?>
