<!--Header-->

<?php
#make firstName, LastName, email, and isAdmin editable
#Register page
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
    		<?php 
    			#should I make the entire patron table editable?
    			$username = "";
    			$usernameError = "";
				$query = mysqli_query($dbCon, "select * from Patron");
    			while ($result = mysqli_fetch_array($query))
    			{
    				if ($result["isAdmin"])
    				{
	    				echo "<tr>";
	    				echo "<td>".$result["userName"]."</td>";
	    				echo "<td><input type='text' value='".$result["email"]."'></td>";
	    				echo "<td><input type='text' value='".$result["phoneNumber"]."'></td>";
	    				if($result["isAdmin"])
						{
							echo "<td><input type='checkbox' checked></td>";
						}
						else
						{
							echo "<td><input type='checkbox' unchecked></td>";
						}
	    				echo "<td><input type='submit' class='btn btn-primary' value='Submit'></td>";
	    				echo "</tr>";
	    			}
    			}
    		?>
		</table>
		<label>USER LOOKUP</label>
		<table class="userTable" cellspacing="10">
			<tr>
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
			    		echo "<label>ooo</label>";
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
								echo "<td>".$result['userName']."</td>";
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

				    			if (isset($_POST['update'])) 
				    			{
				    				echo "<label>hello</label>";
				    				if(empty(trim($_POST["email"]))) 
				    				{
	    								$usernameError = "Please enter a email.";
	    								echo "<label>$usernameError hi</label>";
	    							}
	    							else if(empty(trim($_POST["phoneNumber"])))
	    							{
	    								$usernameError = "Please enter a phone number.";
	    								echo "<label>$usernameError hello</label>";
	    							}
	    							else
	    							{
	    								$paramUsername = "'".$result['userName']."'";
	    								$paramEmail = "'".trim($_POST["email"])."'";
	    								$paramPhoneNumber = "'".trim($_POST["phoneNumber"])."'";
	    								$paramIsAdmin = "'".$_POST["isAdmin"]."'";
	    								echo "<label>$paramUsername oh</label>";
	    								$insertUserSQL = "UPDATE Patron SET email = ?, phoneNumber = ?, isAdmin = ? WHERE userName = ?";
	    								if($stmt = mysqli_prepare($dbCon, $insertUserSQL)) 
	    								{
	    									mysqli_stmt_bind_param($stmt, "ssss", $paramEmail, $paramPhoneNumber, $paramIsAdmin, $paramUsername);
	    									if(mysqli_stmt_execute($stmt)) 
	    									{
	    										echo "Success!";
	    										#header("location: adminPage.php");
	    									}
	    									else 
	    									{
	    										echo "Oops! Something went wrong. Please try again later.";
	    									}
	    								}
	    							}
	    						}
				    		}
				    		else
				    		{
				    			$usernameError = "User does not exist";
				    		}
							/*

			    			$userSQL = "SELECT * FROM patron WHERE userName = 'timbone'";
			    			$SQLuserName = "";
			    			$SQLemail = "";
			    			$SQLpassWord = "";
			    			$SQLphoneNumber = "";
			    			$SQLisAdmin = "";
			    			$SQLuh = "";
			    			if($nonAdmin = mysqli_prepare($dbCon, $userSQL)) 
			    			{
			    				#mysqli_stmt_bind_param($nonAdmin, "s", $paramUsername);
			    				$paramUsername = "'".trim($_POST["username"])."'";
									echo "<label>$paramUsername</label>";
			    				if(mysqli_stmt_execute($nonAdmin)) 
			    				{ 
									mysqli_stmt_store_result($nonAdmin);
									mysqli_stmt_bind_result($nonAdmin, $SQLuserName, $SQLpassWord, $SQLemail, $SQLphoneNumber, $SQLisAdmin);
									echo "<tr>";
									echo "<td><input type='text' value='".$SQLuserName."'></td>";
									echo "<td><input type='text' value='".$SQLemail."'></td>";
									echo "<td><input type='text' value='".$SQLphoneNumber."'></td>";
									if($SQLisAdmin)
									{
										echo "<td><input type='checkbox' checked></td>";
									}
									else
									{
										echo "<td><input type='checkbox' unchecked></td>";
									}
									echo "<td><input type='submit' class='btn btn-primary' value='Submit'>";
									echo "</tr>";
								}
							}
							*/
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
