<?php if (!isset($_SESSION)) session_start();

if(!isset($_SESSION["loggedin"])) {
	header("Location: login.php");
}

#Include Config File
require_once "../database/config.php";

#Define variables as Empty
$username = "";
$oldPassword = "";
$password = "";
$confirmPassword = "";
$email = "";
$confirmEmail = "";
$phoneNumber = "";

$passwordMatched = 0;
$paramPassword = "";

$oldPasswordError = "";
$passwordError = "";
$confirmPasswordError = "";
$emailError = "";
$confirmEmailError = "";
$phoneNumberError = "";

#Process Form data after form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$password = "";
	#get old hashed password
	$userSQL = "SELECT passWord FROM Patron WHERE userName = ?";
	if($stmt = mysqli_prepare($dbCon, $userSQL)) {
		mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
		if(mysqli_stmt_execute($stmt)) {
			if($passwordResult = mysqli_stmt_get_result($stmt)) 
			{
				while ($passwordArray = mysqli_fetch_array($passwordResult, MYSQLI_NUM))
				{
					foreach($passwordArray as $tempPassword)
					{
						$paramPassword = $tempPassword;
					}
				}
				$username = $_SESSION['username'];
				$email = $_SESSION['email'];
				$phoneNumber = $_SESSION['phoneNumber'];
	
				#Validate PhoneNumber
				if(!empty(trim($_POST["phoneNumber"]))) {
					if(preg_match("/^[0-9]{3}[-]?[0-9]{3}[-]?[0-9]{4}$/", $_POST["phoneNumber"])) {
						$phoneNumber = trim($_POST["phoneNumber"]);
						$phoneNumber = str_replace("-","",$phoneNumber);
					}
					else
					{
						$phoneNumberError = "Invalid format.";
					}
				}
				#validate old Password
				if(!empty(trim($_POST["oldPassword"]))) {
					if(!(password_verify(trim($_POST["oldPassword"]), $paramPassword))) #if password is not empty and is not the same as the database
					{
						$oldPasswordError = "Invalid password";
					} 
					else 
					{ # if old password is not empty and is the same as the database
						$password = trim($_POST["oldPassword"]);
						#Validate new Password
						if(empty(trim($_POST["newPassword"]))) 
						{
							$passwordError = "Please enter a password.";
						}
						elseif(strlen(trim($_POST["newPassword"])) < 8) 
						{
							$passwordError = "Password must be at least 8 characters.";
						#} elseif (!preg_match('/^(?=[a-z])(?=[A-Z])[a-zA-Z]{8,}$/', trim($_POST["password"]))) {
							#$passwordError = "Password must contain at least 1 lowercase letter, 1 uppercase letter and 1 number.";
						}
						else 
						{
							$password = trim($_POST["newPassword"]);
						}
						#Validate confirm Password
						if(empty(trim($_POST["confirmPassword"]))) 
						{
							$confirmPasswordError = "Please confirm password.";
						}
						elseif (trim($_POST["newPassword"]) != trim($_POST["confirmPassword"])) 
						{
							$confirmPasswordError = "Passwords do not match.";
						}
						else 
						{
							$confirmPassword = trim($_POST["confirmPassword"]);
						}
					}
				}
				#Validate Email
				if(!empty(trim($_POST["email"]))) {
					if (!preg_match('/^[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z0-9\.]+$/', $_POST["email"])) {
						$emailError = "Invalid format.";
					} else {
						$email = trim($_POST["email"]);
					}
				}
				#Validate confirm Password
				if(!empty(trim($_POST["confirmEmail"]))) {
					$confirmEmail = trim($_POST["confirmEmail"]);
					if(empty($emailError) && ($email != $confirmEmail)) {
						$confirmEmailError = "Emails do not match.";
					}
				}
				#Check input errors before inserting into database
				if(empty($oldPasswordError) && empty($passwordError) && empty($confirmPasswordError) && empty($phoneNumberError) && empty($emailError) && empty($confirmEmailError) && (!empty($paramPassword) || !empty($password)) && !empty($username) && !empty($email) && !empty($phoneNumber)) {
					#Prepare an insert statement
					$insertUserSQL = "UPDATE Patron SET passWord = ?, email = ?, phoneNumber = ? WHERE userName = ?";
					if($stmt = mysqli_prepare($dbCon, $insertUserSQL)) {
						#Bind variables to statement as parameters
						#Set parameters
						$paramUsername = $username;
						$paramEmail = $email;
						$paramPhone = $phoneNumber;
						#Hash password for storage
						if(!empty($password)) {
							$paramPassword = password_hash($password, PASSWORD_DEFAULT);
						}
						mysqli_stmt_bind_param($stmt, "ssss", $paramPassword, $paramEmail, $paramPhone, $paramUsername);
						#Execute prepared statment
						if(mysqli_stmt_execute($stmt)) {
							#Redirect to Login page
							$_SESSION['email'] = $paramEmail;
							$_SESSION['phoneNumber'] = $paramPhone;
							header("location: ../mainPages/myAccount.php");
						} else {
							echo "Oops! Something went wrong. Please try again later.";
						}
						#Close statement
						mysqli_stmt_close($stmt);
					}
				}
			}
		}
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
        <h2>Edit User Profile</h2>
        <p>Complete this form to change account info.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($phoneNumberError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Phone Number (1234567890)</label>
						<input type="tel" placeholder="<?php echo $_SESSION["phoneNumber"]; ?>" maxlength="12" name="phoneNumber" class="form-control" value="<?php echo $phoneNumber; ?>">
            <span class="help-block"><?php echo $phoneNumberError; ?></span>
					</div>
					<br/>
          <div class="form-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Email</label>
						<input type="email" name="email" class="form-control" placeholder="<?php echo $_SESSION["email"]; ?>" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $emailError; ?></span>
          </div>
					<br/>
          <div class="form-group <?php echo (!empty($confirmEmailError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Confirm Email</label>
            <input type="email" name="confirmEmail" class="form-control" value="<?php echo $confirmEmail; ?>">
            <span class="help-block"><?php echo $confirmEmailError; ?></span>
					</div>
					<br/>
					<div class="form-group <?php echo (!empty($oldPasswordError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Old Password</label>
            <input type="password" name="oldPassword" class="form-control" value="<?php echo $oldPassword; ?>">
            <span class="help-block"><?php echo $oldPasswordError; ?></span>
          </div>
					<br/>
          <div class="form-group <?php echo (!empty($passwordError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>New Password</label>
            <input type="password" name="newPassword" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $passwordError; ?></span>
          </div>
					<br/>
          <div class="form-group <?php echo (!empty($confirmPasswordError)) ? 'has-error' : ''; ?>" style="width: 350px; display: inline-block;">
            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" value="<?php echo $confirmPassword; ?>">
            <span class="help-block"><?php echo $confirmPasswordError; ?></span>
          </div>
					<br/>
          <div clas="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div>
					<br/>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
    <!---FOOTER--->
    <?php #require "../sharedParts/footer.php"; ?>
