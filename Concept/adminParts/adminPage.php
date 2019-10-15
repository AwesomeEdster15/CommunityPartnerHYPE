<!--Header-->

<?php
#<!--Initialize Session-->
if (!isset($_SESSION)) session_start();

#Include Config File
require_once "../database/config.php";

#Define variables as Empty
?>

<?php require "../sharedParts/header.php"; ?>
  <!---MAIN----->
  <div class="main">



    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Hello!</h1>
        <p>
          This is where you can view all the fancy Admin only controls.
        </p>
      </div>
    </div>



    <!--Section 2-->
    <section>
    	<table class="adminTable" cellspacing="10">
    		<label>ADMINS</label>
    		<tr class="adminTable">
    			<td>userName</td>
    			<td>Email</td>
    			<td>phoneNumber</td>
    			<td>isAdmin</td>
    		</tr>

    		<!-- List all of the admins -->
    		<?php
    			$username = "";
    			$usernameError = "";
				$query = mysqli_query($dbCon, "select * from Patron");
    			while ($result = mysqli_fetch_array($query))
    			{
    				if ($result["isAdmin"])
    				{
	    				# create a table to store the information 
	    				echo "<tr>";
	    				echo "<td>".$result["userName"]."</td>";
	    				echo "<td><input type='text' value='".$result["email"]."'></td>";
	    				echo "<td><input type='text' value='".$result["phoneNumber"]."'></td>";
	    				
	    				# check the box if the user is an admin.
	    				# All should be admin, but did this in case of future changes.
	    				if($result["isAdmin"])
							echo "<td><input type='checkbox' checked></td>";
						else
							echo "<td><input type='checkbox' unchecked></td>";

						# The Submit button at the end of each line
						echo "<td><input type='submit' class='btn btn-primary' value='Submit'></td>";
	    				echo "</tr>";
	    			}
    			}
    		?>
		</table>

		<!-- created a way to lookup and edit info for any user -->
		<label>USER LOOKUP</label>
		<table class="userTable" cellspacing="10">
			<tr>
			<!-- the form for the user lookup, with isset name userChoice -->
    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    			<div class="form-group <?php echo (!empty($usernameError)) ? 'has-error' : ''; ?>" style="width: 350px; display:inline;">
	    			<td><input type='text' name='username' class='form-control' value="<?php echo $username; ?>"></td>
		    		<td><input type='submit' name='userChoice' class='btn btn-primary' value='Submit'></td>
		    		<td><span class="help-block"><?php echo $usernameError; ?></span></td>
		    	</div>
		    </form>
    		</tr>


    		<?php
    			if($_SERVER["REQUEST_METHOD"] == "POST") {
    				if (isset($_POST['userChoice']))
			    	{
	    				if(empty(trim($_POST["username"]))) {
	    					$usernameError = "Please enter a username.";
	    				}
	    				else
	    				{
	    					$paramUsername = trim($_POST["username"]);
	    					$userSQL = "SELECT * FROM Patron WHERE userName = '".$paramUsername."'";
	    					$query2 = mysqli_query($dbCon, $userSQL);
	    					$result = mysqli_fetch_array($query2);
	    					if($result['userName'])
	    					{
		    					echo "<table class='userTable' cellspacing='10'>";
		    					echo "<tr class='userTable'>";
					    		echo "<td>userName</td>";
					    		echo "<td>Email</td>";
					    		echo "<td>phoneNumber</td>";
					    		echo "<td>isAdmin</td>";
				    			echo "</tr>";
								echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post' name='updateUser'>";
				    			echo "<div class='form-group' style='width: 350px; display:inline;'>";
								echo "<tr>";
								echo "<td><input type='text' name='userName' value='".$result['userName']."'</input></td>";
								echo "<td><input type='text' name='email' value='".$result["email"]."'></td>";
								echo "<td><input type='text' name='phoneNumber' value='".$result["phoneNumber"]."'></td>";
								if($result["isAdmin"])
								{
									echo "<td><input type='checkbox' name='isAdmin' checked></td>";
								}
								else
								{
									echo "<td><input type='checkbox' name='isAdmin' unchecked></td>";
								}
								echo "<td><input name='update' type='submit' class='btn btn-primary' value='Submit'></td>";
								echo "<td><span class='help-block'><?php echo $usernameError; ?></span></td>";
								echo "</tr>";
				    			echo "</div>";
				    			echo "</form>";
				    		}
				    		else
				    		{
				    			$usernameError = "User does not exist";
				    		}
						}
					}

					# Update the user info
					if (isset($_POST['update']))
					{
						#error checking for Null, need to add data constraints
						if(empty(trim($_POST["email"])))
						{
							echo "Please enter a email.";
						}
						else if(empty(trim($_POST["phoneNumber"])))
						{
							echo "Please enter a phone number.";
						}
						else
						{
							$paramUsername = trim($_POST["userName"]);
							$paramEmail = trim($_POST["email"]);
							$paramPhoneNumber = trim($_POST["phoneNumber"]);

							if(isset($_POST["isAdmin"]))
							{
								$paramIsAdmin = 1;
							}
							else
							{
								$paramIsAdmin = 0;
							}
							$insertUserSQL = "UPDATE Patron SET email = ?, phoneNumber = ?, isAdmin = ? WHERE userName = ?";
							if($stmt = mysqli_prepare($dbCon, $insertUserSQL))
							{
								mysqli_stmt_bind_param($stmt, "ssis", $paramEmail, $paramPhoneNumber, $paramIsAdmin, $paramUsername);
								if(mysqli_stmt_execute($stmt))
								{
									echo "Success!";
									header("location: adminPage.php");
								}
								else
								{
									echo "Oops! Something went wrong. Please try again later.";
								}
							}
						}
					}
				}
    		?>

    	</table>
    </section>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
