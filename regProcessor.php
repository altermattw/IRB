<?php
	include('php/SQLutils.php');
	$WM = getWM();
	function registerUser($mysqli, $data) {
		// adds records to $tableName
		// $data is a named array, with keys = variable name and values = data from one person			
		$stmt = mysqli_prepare($mysqli, "INSERT INTO users (lastName, firstName, email, password, status, hash, validated, lastLogin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");		
		mysqli_stmt_bind_param($stmt, 'ssssssii', $lastName, $firstName, $email, $password, $status, $hash, $validated, $lastLogin);		
		$lastName = $data["lastName"];
		$firstName = $data["firstName"];
		$email = $data["email"];
		$password = $data["password"];
		$status = $data["status"];
		$hash = $data["hash"];
		$validated = $data["validated"];
		$lastLogin = $data["lastLogin"];

		if(mysqli_stmt_execute($stmt)) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}	
  $pageTitle = 'HC IRB Registration';
  include('php/navbar.php');
  $ending = '</div></div></div></body></html>';
  $WM = getWM();
?>


						<h2>HC IRB Registration<br>							
						</h2>						
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
<?php
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";

	
	$results = array();	

	if(isset($_POST["lastName"])) { // Registering for the first time
		$email = (string) $_POST["email"];
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@hanover.edu$", $email)){ // checking if there is an email problem.				
		    // Return Error - Invalid Email
				echo '<p>Error: The email address you entered ('.$email.') did not end with @hanover.edu. This form is only for students and employees of Hanover College. For questions about IRB policies, please contact the chair of the IRB, '.$IRBchair["name"].', at '.$IRBchair["email"].'. If you believe you received this message in error, please contact the webmaster for the HC IRB, '.$WM["name"].', at '.$WM["email"].'.</p>'.$ending;
				die();
		}		
		// processing incoming data
			$accepted = array("lastName", "firstName", "email", "password");
			foreach ( $_POST as $foo=>$bar ) {
	    if ( in_array( $foo, $accepted ) && !empty($bar) ) {
	        $results[$foo] = (string) $bar; // adding all the POSTed registration info to $results array
		    }
			}
			$results["password"] = encryptPassword($results["password"]);		
			$results["hash"] = makeHash(); // creating a hash for email verification
			$results["validated"] = 0; // haven't yet validated by email		
			$results["lastLogin"] = time();
			$emailUsernamePre = explode('@',$email); // first half of email = username
			$emailUsername = $emailUsernamePre[0];
			if(preg_match('/[0-9]{2}$/',$emailUsername)) { // email ends with 2 numbers; user is a student
				$results["status"] = 'student';
			} else {
				$results["status"] = 'faculty';
			}
				
		// check to see if someone with that email address is already registered	
		
		$mysqli = myConnect();

		if(userExists($email,$mysqli)) {
			// email already registered!			
			echo '<p>Hmm...It seems that email address ('.$email.') has already been registered with the IRB. You might try <a href="login.php">logging in</a>. If you have forgotten your password, you can reset it by clicking <a href="../resetPassword.html">here</a>.</p>'.$ending;
			mysqli_close($mysqli);
			die();
		} else {
			// email has not been registered; add to database			
			$feedback = '';
			if(registerUser($mysqli,$results)) { // if successful addition to database
				mysqli_close($mysqli);
				echo '<p>Thank you! Your information has been recorded in the IRB database.</p>';
				echo mailVerification($email,$results["hash"]).$ending;	 				
				die();								
			} else {
				mysqli_close($mysqli);
				echo '<p>There was a problem adding your records to the IRB database. Please <a href="/register.php">try again</a> or contact the webmaster, '.$WM["name"].', at '.$WM["email"].'. Sorry for the inconvenience.</p></div></div></div></div></body></html>';
				die();
			}
		}
	} else { // no last name POST info
		echo '<p>No last name was received from the form linked to this processing page. Please try completing the <a href="/register.php">registration form</a> again. If the problem persists, contact the webmaster, '.$WM["name"].', at '.$WM["email"].'</p></div></div></div></div></body></html>';
		mysqli_close($mysqli);
		die();
	} 

	
?>