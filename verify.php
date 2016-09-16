<?php
	include('php/SQLutils.php');
	$pageTitle = 'HC IRB Email Verification';
	include('php/navbar.php');

	function verifyEmail($email, $mysqli) {
		$email = mysqli_escape_string($mysqli,$email);
		$query = 'UPDATE users SET validated=1 WHERE email="'.$email.'"';		
		if ($mysqli->query($query)) {			
			return TRUE; 
		} else {				
			return FALSE;
		}	
	}

?>
					<h2>Hanover College Institutional Review Board (IRB) Email Verification<br>							
					</h2>						
				</div>
				<div class="col-md-6 col-md-offset-3">
<?php
// receiving email verification for registration
	if(isset($_GET["hash"]) && isset($_GET["email"])) {
		$hash = (string) $_GET["hash"];
		$email = (string) $_GET["email"];			
		
		// check to see if someone with that email address is already registered
		$mysqli = myConnect();

		if(userExists($email,$mysqli)) {					
			$row = getUserRecord($email,$mysqli);			
			if(array_key_exists("hash",$row)) {
				if($row['hash'] === $hash) { // email verified
					// hash codes match!
						// update record to set 'verified' to 'true'						
						if(verifyEmail($email,$mysqli)) {
							echo '<p>Success! Your email address has been verified. You can now access your account by <a href="login.php">logging in</a>.</p></div></div></div></div></body></html>';
							$mysqli->close();
							die();
						} else { // email verification failed
							echo '<p>Uh-oh. There was a problem updating your account to email-verified status. Please contact the HC IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.</p></div></div></div></div></body></html>';
							$mysqli->close();
							die();
						}			
				} else { // hash code does not match!
					echo '<p>Sorry, but the verification code does not match the one in the records. Check your email to see if you received a more recent link. If that doesn&rsquo;t work, you could try initiating a change of password at the <a href="index.php">login screen</a>. If you continue to have problems, contact the HC IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.</p></div></div></div></div></body></html>';					
					die();
				}	
			} else {
				echo '<p>No email verification code was found in the database for this email account. If you have not yet registered, you can do so <a href="../register.html">here</a>. If you continue to have problems, you can contact the IRB webmaster, '.$IRBwebmaster["name"].' at '.$IRBwebmaster["email"].'.</p></div></div></div></div></body></html>';
				die();
			}				
		} else { // no email in the database
			echo '<p>Sorry, but we were unable to find your email address in the records. Check your email to see if you received a more recent link. If you continue to have problems, contact the HC IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.</p></div></div></div></div></body></html>';
			die();
		}			
	} else {
		echo '<p>Sorry, but no information was transmitted to verify your email address. If you are trying to verify your IRB account, please check your email and click on the link provided. If you continue to have trouble, please contact the webmaster for the IRB, '.$IRBwebmaster["name"].' at '.$IRBwebmaster["email"].'.</p></div></div></div></div></body></html>';
		die();
	} 
?>			