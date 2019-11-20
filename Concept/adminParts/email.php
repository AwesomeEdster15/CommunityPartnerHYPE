<?php
	require_once "/var/www/html/CommunityPartnerHYPE/Concept/database/config.php";

	# Error checking. Probably should remove before production, but won't be seen anyway
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	# Constant variables
	$daysNotice = 5;

	# Preset variables
  $email = "";
  $username = "";
  $product = "";
	$days = 9999;
	$dueDate = "";

	# Get todays date
	$date = date_create();
	$today = date_format($date, '[Y-m-d H:i:s]'); # in log format
	$now = date_format($date, 'Y-m-d'); # in comparison format

  $resQuery = mysqli_query($dbCon, "select * from Reservation");
  while($resResult = mysqli_fetch_array($resQuery))
	{
		#determine the date in $daysNotice time, to easily compare with today's date
		$retDate = date_create($resResult["expectedReturnDate"]);
		date_sub($retDate, date_interval_create_from_date_string("$daysNotice days"));
		$futureNotice = date_format($retDate, 'Y-m-d');

		#determine the due date
		$retDate = date_create($resResult["expectedReturnDate"]);
		$returnDate = date_format($retDate, 'Y-m-d');

		if(($futureNotice == $now || $returnDate == $now) && $resResult["status"] == "Checked Out")
		{
			if($futureNotice == $now) {
				$days = $daysNotice;
			} else {
				$days = 0; 
			}

			$username = $resResult["userName"];
			$dueDate = $resResult["expectedReturnDate"];

			#This seems unnecessary to retrieve 1 variable
			$prodQuery = "SELECT productName from Item WHERE itemID = ?";
      if($stmt = mysqli_prepare($dbCon, $prodQuery)) {
				mysqli_stmt_bind_param($stmt, "s", $resResult["itemID"]);
				if(mysqli_stmt_execute($stmt)) {
					if($prodResult = mysqli_stmt_get_result($stmt)) {
						while($prodArray = mysqli_fetch_array($prodResult, MYSQLI_NUM)) {
							foreach($prodArray as $tempProd) {
								$product = $tempProd;
							}
            }
          }
        }
			}

			#This seems unnecessary to retrieve 1 variable
      $patronQuery = "SELECT email FROM Patron WHERE userName = ?";
      if($stmt = mysqli_prepare($dbCon, $patronQuery)) {
				mysqli_stmt_bind_param($stmt, "s", $username);
				if(mysqli_stmt_execute($stmt)) {
					if($patronResult = mysqli_stmt_get_result($stmt)) {
						while($patronArray = mysqli_fetch_array($patronResult, MYSQLI_NUM)) {
							foreach($patronArray as $tempPatron) {
								$email = $tempPatron;
							}
            }
          }
        }
			}

			#send an email if all information is available, and the return date is either $daysNotice days away, or today
			if(!empty($email) && !empty($username) && !empty($product) && !empty($dueDate))
			{
				if($days == 0) {
					$message = "This is a not so friendly reminder that the $product is due today. Please return this item as soon as you can!";
					$signOff = "Thank you,\nCommunity Partnership of Rolla";
					$email_body = "$username,\n\n" . "$message\n\n" . "$signOff\n";
					$subject = "$product is due today\n";
				} else {
					$message = "This is a friendly reminder that the $product is due in $daysNotice days. Please return this item at your earliest convience."; 
					$signOff = "Thank you,\nCommunity Partnership of Rolla";
					$email_body = "$username,\n\n".  "$message\n\n" . "$signOff\n";
					$subject = "$product is due in $days days\n";
				}

				# attempt to send an email, and report the outcome
				if(mail($email,$subject, $email_body)) {
					error_log("$today Email reminder successfully sent to $username at $email for $product due on $dueDate\n", 3, "/home/community/.msmtp.log");
					print("$today Email reminder successfully sent to $username at $email for $product due on $dueDate <br>\n");
				} else {
					error_log("An error occured while sending email\n", 3, "/home/community/.msmtp.log");
					print("$today Email failed to send to $username at $email for $product due on $dueDate <br>\n");
				}
			}
			# report any attempts to send an email without full information
			else
			{ 
				error_log("form failure\n", 3, "/home/community/.msmtp.log");
				print("form failed");
			}

			#reset the variables for the while loop
			$email = "";
			$username = "";
			$product = "";
			$days = 9999;
			$dueDate = "";
		}
	}
?>

