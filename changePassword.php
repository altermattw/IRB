<?php
	// Note: This is a form where the user enters their new password.
	// They should arrive here after clicking a link in their email.
	// The form passes the information along to changePassword.php
	include('php/SQLutils.php');
	$pageTitle = 'Hanover College IRB Change Password';
	include('php/navbar.php');
?>

<?php
// Note:  This form processes the very end of the password reset process.
// It receives the new password from the setNewPassword.php form and updates the db.

	$end = '</p></div></div></div></div></body></html>';
	$WM = getWM();
	$contact = 'If you continue to have trouble, please contact the IRB webmaster, '.$WM["name"].', at '.$WM["email"].'.';
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";	
	$subject = 'HC IRB password changed';					
	$message = '<html><body style="font-family: Arial,Serif">';
	$message .= '<p>This is an automatic email sent from the Hanover College IRB database. Your password has just been changed. You may now <a href="http://irb.hanover.edu/index.php">log in</a> using your new password. If you did not perform this password change or you have any questions, please contact the webmaster for the IRB, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'</p>';	
	$message .= '</body></html>';
?>

						<p>
							<?php
								if(!isset($_POST["email"]) || !isset($_POST["hash"])) {
									echo 'There was a problem receiving information from the previous form. You could try clicking the Back button on your browser or you can re-initiate the password reset process <a href="resetPassword.html">here</a>. '.$contact.$end;									
									die();
								} else {
									$email = $_POST["email"];
									$hash = $_POST["hash"];
									$password = $_POST["password"];
									$mysqli = myConnect();
									// check to see if email account exists in database
									if(userExists($email,$mysqli)) {										
										$userRecord = getUserRecord($email,$mysqli);
										if(time()-$userRecord["changeTime"] > 24*60*60) { // too old
											echo 'This password reset request is more than 24 hours old. Please <a href="resetPassword.html">initiate a new password reset request</a>. '.$contact.$end;											
											die();
										} else { // request is within 24 hours																						
											if($userRecord["changeHash"] === $hash) { // hash codes match
												$password = encryptPassword($password);
												$query = 'UPDATE users SET password="'.$password.'", changeTime=0, changeHash=0 WHERE email="'.$email.'"';
												if(!mysqli_query($mysqli,$query)) {
													echo '<p>Sorry! There was a problem resetting your password. Please contact the webmaster, '.$WM["name"].', at '.$WM["email"].', and report the error code printed below. Thanks!</p>';
													echo '<p>Query: '.$query.'</p>';
													echo '<p>Error: '.mysqli_error($mysqli).'</p>';
												} else {
													echo 'Password successfully updated. Please <a href="login.php">log in</a> to continue.';
													$subject = 'HC IRB password has been reset';					
													$message = '<p>This is an automatic email sent from the Hanover College IRB database. Your password has been changed and you should be able to use use it to <a href="http://irb.hanover.edu/login.php">login</a>. If you did not change your password, please contact the webmaster for the IRB, '.$WM["name"].', at '.$WM["email"].'</p>';													
													if(mailMessage($email,$subject,$message)) {
														// mail sent
														echo '<p>An email confirmation of your password change has been sent to '.$email.'.</p>';
													} 																											
													echo $end;
												}		
											} else {
												echo '<p>Your password change request code does not match the most recent one in the database. Check your email to see if you have a more recent password change request notification from the IRB. You can also <a href="resetPassword.html">initiate a new password change request</a>. '.$contact.'</p>';
											}
										}
									} else { // email not in database
										echo 'That email ('.$email.') was not found in the database. If it was spelled incorrectly, please <a href="resetPassword.html">re-initiate a password reset request</a>. If you have not yet registered with the IRB, you can do so <a href="register.php">here</a>. '.$contact.$end;	
										die();
									}									
								}
							?>