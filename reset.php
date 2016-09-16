<?php
	// Note: This form receives a user's email address from resetPassword.html
	// It marks the account with a reset code and a time stamp.
	// It then sends an email to the user with a link. 
	// Clicking that link takes the user to setNewPassword.html
	include('php/SQLutils.php');
	$pageTitle = 'Hanover College IRB Reset Password';
	include('php/navbar.php');
?>
<?php
	
	$end = '</div></div></div></div></body></html>';
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";	
	$WM = getWM();
	// initialize password reset


		if(isset($_POST["email"])) {
			$email = (string) $_POST["email"];			
			$feedback = "";

			// check to see if that email is already in the database
			$mysqli = myConnect();
			if(userExists($email,$mysqli)) { // if yes:	
				$hash = md5( rand(0,1000) );
				$time = time();
				$query = 'UPDATE users SET changeTime='.$time.', changeHash="'.$hash.'" WHERE email="'.$email.'"';
				if(!mysqli_query($mysqli,$query)) {
					echo '<p>Sorry! There was a problem resetting your password. Please contact the webmaster, '.$WM["name"].', at '.$WM["email"].', and report the error code printed below. Thanks!</p>';
					echo '<p>Query: '.$query.'</p>';
					echo '<p>Error: '.mysqli_error($mysqli).'</p>';
				} else {
					$subject = 'HC IRB reset password';					
					$message = '<p>This is an automatic email sent from the Hanover College IRB database. To reset your password, please click the link below (or copy and paste it into your browser) within 24 hours. If you did not submit a password reset request, don&rsquo;t worry; your password cannot be changed without an email confirmation. If you have any questions, you may contact the webmaster for the IRB, '.$WM["name"].', at '.$WM["email"].'</p>';
					$message .= '<p><a href="http://irb.hanover.edu/setNewPassword.php?email='.$email.'&hash='.$hash.'">http://irb.hanover.edu/setNewPassword.php?email='.$email.'&hash='.$hash.'</a></p>';
					if(mailMessage($email,$subject,$message)) {
						// mail sent
						echo '<p>An email message has been sent to '.$email.'. Please check your email and click the link in the email within 24 hours to reset your password.</p>'.$end;
					} else {
						// mail not sent
						echo '<p>There was a problem sending the email to '.$email.'. Please check the address to make sure it is correct and <a href="../resetPassword.html">try again</a>. If you continue to have problems, please contact the IRB webmaster, '.$WM["name"].', at '.$WM["email"].'. Sorry for the inconvenience.</p>'.$end;    
					}
				}				
			} else { // nobody in the db with that email
				echo '<p>There is no user with email account '.$email.' in the database. To register with the IRB, please <a href="register.php">click here</a> or contact the webmaster for the HC IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' for assistance.'.$end;								
			}
			mysqli_close($mysqli);	    
		} else {
			echo '<p>No email address was sent with that password reset request. Please <a href="resetPassword.html">try again</a> or contact the webmaster for the HC IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' for assistance.'.$end;			
		}	
	
?>