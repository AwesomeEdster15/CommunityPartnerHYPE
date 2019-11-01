<?php if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["isAdmin"]))
{
	header("Location: ../accountParts/login.php");
}

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
        <h1 id='testing' class="title">Hello!</h1>
        <p>
          This is where you can view all the fancy Admin only controls.
        </p>
      </div>
    </div>


    <!--Section 2-->
    <section>
			<input type='text' id='searchBar' onkeyup="search()" name='username' class='form-control' value="<?php echo $username; ?>">
			<table id='itemTable'>
    		<tr class="adminTable">
    			<th>userName</th>
    			<th>Email</th>
    			<th>phoneNumber</th>
    			<th>isAdmin</th>
    		</tr>

    		<?php
    			$username = "";
    			$usernameError = "";
					$query = mysqli_query($dbCon, "select * from Patron");
					$count = 0;
    			while ($result = mysqli_fetch_array($query))
					{
    				if ($result["isAdmin"])
    				{
							# create a table to store the information
							$count += 1;
							echo "<tr>
							<td><label>".$result["userName"]."</label></td>
							<td><label>".$result["email"]."</label></td>
							<td><label>".$result["phoneNumber"]."</label></td>
							<td><input type='checkbox' name='isAdmin".$count."' value='".$result['userName']."' checked ".($_SESSION['isAdmin']==2 ? '' : 'disabled')."></td>
							</tr>";
	    			}
    			}
					$query2 = mysqli_query($dbCon, "select * from Patron");
					while ($result = mysqli_fetch_array($query2))
					{
						if(!$result['isAdmin'])
						{
							echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post'>
								<tr>
								<td><label>".$result['userName']."</label></td>
								<td><label>".$result['email']."</label></td>
								<td><label>".$result['phoneNumber']."</label></td>
								<td><input type='checkbox' name='check_list[]' value='".$result['userName']."' ".($_SESSION['isAdmin']==2 ? '' : 'disabled')."></td>";
								echo "</tr>";
						}
					}
					echo "</table>";
					if($_SESSION["isAdmin"] == 2)
					{
						echo "<input name='update' type='submit' class='btn btn-primary' value='Update Admin Permissions'>";
					}
					echo "</form>";

					if(isset($_POST['update']))
					{
						if(!empty($_POST['check_list']))
						{
							$checked_count = count($_POST['check_list']);
							echo "<br/>You have selected the following ".$check_count." option(s): <br/>";
							foreach($_POST['check_list'] as $selected)
							{
								echo "<p>".$selected ."</p>";
								$paramUsername = trim($selected);
								$paramIsAdmin = 1;
								$insertUserSQL = "UPDATE Patron SET isAdmin = ? WHERE userName = ?";
								if($stmt = mysqli_prepare($dbCon, $insertUserSQL))
								{
									mysqli_stmt_bind_param($stmt, "is", $paramIsAdmin, $selected);
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
						/*
						for ($i = 1; $i <= $count; $i++)
						{
							if($_POST["isAdmin.$i"]=='bobb')
							{
								echo "<p>hi".$_POST["isAdmin.$i"]."</p>";
							}
							else
							{
								echo "<br/>this isAdmin".$i;
							}
						}
						 */
					}
    		?>
			<script>
				function search() 
				{
					var input, filter, table, tr, td, i, txtValue;
					input = document.getElementById("searchBar");
					filter = input.value.toUpperCase();
					table = document.getElementById("itemTable");
					tr = table.getElementsByTagName("tr");
					for (i = 0; i < tr.length; i++) 
					{
						td = tr[i].getElementsByTagName("td")[0];
						if (td) 
						{
							txtValue = td.textContent || td.innerText;
							if (txtValue.toUpperCase().indexOf(filter) > -1) 
							{
								tr[i].style.display = "";
							}
							else 
							{
								tr[i].style.display = "none";
							}
						}
					}
				}
			</script>
	

    </section>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
