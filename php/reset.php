<?php
	// Note: This form receives a user's email address from resetPassword.html
	// It marks the account with a reset code and a time stamp.
	// It then sends an email to the user with a link. 
	// Clicking that link takes the user to setNewPassword.html
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">				 
  	<link href="/~altermattw/css/bootstrap.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/css/bootstrap-theme.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/css/styles.css" rel="stylesheet" media="screen">
		<script src="/~altermattw/js/jquery-1.10.2.min.js"></script>
		<script src="/~altermattw/js/bootstrap.min.js"></script>		
		<title>HC IRB Reset Password</title>		
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="page-header">
						<h2>Hanover College IRB Reset Password<br>							
						</h2>						
					</div>
					<div class="col-md-6 col-md-offset-3">
<?php
	include('SQLutils.php');
	$end = '</div></div></div></div></body></html>';
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";	

	// initialize password reset


		if(isset($_POST["email"])) {
			$email = (string) $_POST["email"];
			$resetCode = md5( rand(0,1000) );
			$feedback = "";

			// check to see if that email is already in the database
			if(docExists('email',$email,'IRBacc')) { // if yes:
				// update the record with the field "reset" set to time()
				$criteria=array('email' => $email);
				$hash = md5( rand(0,1000) );
				$new_object=array('$set' => array('reset' => time(), 'hash' => $hash));
				if(updateDoc($criteria,$new_object,'IRBacc')) { // if update worked						
					$subject = 'HC IRB reset password';					
					$message = '<html><body style="font-family: Arial,Serif">';
					$message .= '<p>This is an automatic email sent from the Hanover College IRB database. To reset your password, please click the link below (or copy and paste it into your browser) within 24 hours. If you did not submit a password reset request, don&rsquo;t worry; your password cannot be changed without an email confirmation. If you have any questions, you may contact the webmaster for the IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'</p>';
					$message .= '<p><a href="http://vault.hanover.edu/~altermattw/IRB/php/setNewPassword.php?email='.$email.'&hash='.$hash.'">Click this link to create a new password</a></p>';
					$message .= '</body></html>';
					if(mail($email,$subject,$message,$headers)) { // if the email sent
	          $feedback .= '<p>An email message has been sent to '.$email.'. Please check your email and click the link in the email within 24 hours to reset your password.</p>'.$end;
	          echo $feedback;
	          $client->close();
	          die();
		      } else { // if the email did not send
	        	$feedback .= '<p>There was a problem sending the email to '.$email.'. Please check the address to make sure it is correct and <a href="../resetPassword.html">try again</a>. If you continue to have problems, please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'. Sorry for the inconvenience.</p>'.$end;    
	        	echo $feedback;
	        	$client->close();
	        	die();
	        }
				} else { // if update did not work
					$feedback .='<p>Sorry, but there was a problem updating your password. Please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' for assistance.</p>'.$end;	
					echo $feedback;
        	$client->close();
        	die();
				}
			} else { // nobody in the db with that email
				$feedback.='<p>There is no user with email account '.$email.' in the database. To register with the IRB, please <a href="../register.html">click here</a> or contact the webmaster for the HC IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' for assistance.'.$end;				
				echo $feedback;
				$client->close();
				die();
			} 	    
		} else {
			echo '<p>No email address was sent with that password reset request. Please <a href="../resetPassword.html">try again</a> or contact the webmaster for the HC IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' for assistance.'.$end;
			$client->close();
			die();
		}	
?>