<?php
// Note:  This form processes the very end of the password reset process.
// It receives the new password from the setNewPassword.php form and updates the db.
	include('utils.php');
	$end = '</p></div></div></div></div></body></html>';
	$contact = 'If you continue to have trouble, please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.';
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";	
	$subject = 'HC IRB password changed';					
	$message = '<html><body style="font-family: Arial,Serif">';
	$message .= '<p>This is an automatic email sent from the Hanover College IRB database. Your password has just been changed. You may now <a href="http://vault.hanover.edu/~altermattw/IRB/index.php">log in</a> using your new password. If you did not perform this password change or you have any questions, please contact the webmaster for the IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'</p>';	
	$message .= '</body></html>';
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
		<title>Hanover College IRB Change Password</title>
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="page-header">
						<h2>Changing Password for HC IRB<br>							
						</h2>
						<p>
							<?php
								if(!isset($_POST["email"]) || !isset($_POST["hash"])) {
									echo 'There was a problem receiving information from the previous form. You could try clicking the Back button on your browser or you can re-initiate the password reset process <a href="../resetPassword.html">here</a>. '.$contact.$end;
									$client->close();									
									die();
								} else {
									$email = $_POST["email"];
									$hash = $_POST["hash"];
									$password = $_POST["password"];
									// check to see if email account exists in database
									if(docExists('email',$email,'IRBacc')) {										
										$doc = getDoc('email',$email,'IRBacc');
										if(!array_key_exists('reset', $doc)) { // account not marked for reset!
											echo 'This account has not been marked for password reset. Please initialize a password reset request <a href="../resetPassword.html">here</a>. '.$contact.$end;
											$client->close();
											die();
										} else { // account is marked for reset
											if((time()-$doc["reset"]) > 24*60*60) { // more than 24 hours
												echo 'This password reset request is more than 24 hours old. Please <a href="../resetPassword.html">initiate a new password reset request</a>. '.$contact.$end;
												$client->close();
												die();
											} else { // less than 24 hours
												if($doc["hash"] === $hash) { // hash codes match
													$password = encryptPassword($password);
													$criteria = array('email' => $email);
													$new_object = array('password' => $password);
													if(updateDoc($criteria,$new_object,$IRBacc)) { // update successful
														echo 'Password successfully updated. Please <a href="../index.php">log in</a> to continue.'.$end;
														mail($email,$subject,$message,$headers);												
														$client->close();
														die();
													} else { // update not successful
														echo 'Uh-oh. There was a problem changing your password on the database. You could try reloading this page or <a href="../resetPassword.html">re-initiating the password reset request</a>. '.$contact.$end;
														$client->close();
														die();
													}
												} else { // hash codes don't match
													echo 'Uh-oh. The reset code from your email does not match the reset code in the database. Check your email to see if you received a more recent email from the IRB. You can also <a href="../resetPassword.html">re-initiate a password reset</a>. '.$contact.$end;
													$client->close();
													die();
												}
											}											
										}
									} else { // email not in database
										echo 'That email ('.$email.') was not found in the database. If it was spelled incorrectly, please <a href="../resetPassword.html">re-initiate a password reset request</a>. If you have not yet registered with the IRB, you can do so <a href="../register.html">here</a>. '.$contact.$end;
										$client->close();
										die();
									}									
								}
							?>