<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">				 
  	<link href="/~altermattw/dev/css/bootstrap.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/dev/css/bootstrap-theme.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/dev/css/styles.css" rel="stylesheet" media="screen">
		<script src="/~altermattw/dev/js/jquery-1.10.2.min.js"></script>
		<script src="/~altermattw/dev/js/bootstrap.min.js"></script>		
		<title>Hanover College IRB</title>			
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="page-header">
						<h2>Hanover College Institutional Review Board (IRB)<br>							
						</h2>						
					</div>
					<div class="col-md-6 col-md-offset-3">
<?php
	$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
	$database = "research";
	$username = "altermattw";
	$passwd = "calliope77";
	$uri = "mongodb://".$username.":".$passwd."@ds061228.mongolab.com:61228/".$database;
	$options = array("connectTimeoutMS" => 30000);
	$accepted = array("lastName", "firstName", "email", "password", "status");
	$results = array();
	$results["startDate"] = time();	
	if(isset($_POST["lastName"])) { // Registering for the first time
		$email = (string) $_POST["email"];
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@hanover.edu$", $email)){ // checking if there is an email problem.				
		    // Return Error - Invalid Email
				echo '<p>Error: The email address you entered ('.$results["email"].') did not end with @hanover.edu. This form is only for students and employees of Hanover College. For questions about IRB policies, please contact the chair of the IRB, Dean Jacks, at jacks@hanover.edu. If you believe you received this message in error, please contact the webmaster for the HC IRB, Bill Altermatt, at altermattw@hanover.edu.</p></div></div></div></div></body></html>';
				die();
		}		
		
		foreach ( $_POST as $foo=>$bar ) {
    if ( in_array( $foo, $accepted ) && !empty($bar) ) {
        $results[$foo] = (string) $bar; // adding all the POSTed registration info to $results array
	    }
		}
		$password = $results["password"];
		$random = openssl_random_pseudo_bytes(18);
		$salt = sprintf('$2y$%02d$%s',
		    13, // 2^n cost factor
		    substr(strtr(base64_encode($random), '+', '.'), 0, 22)
		);
		$results["password"] = crypt($password, $salt); // encrypting password		 
		$results["hash"] = md5( rand(0,1000) ); // creating a hash for email verification
		$results["verified"] = 'false'; // haven't yet verified by email
		
		$client = new MongoClient($uri, $options );
		$db = $client->selectDB($database);
		$IRB = $db->IRB; // accessing collection
		// check to see if someone with that email address is already registered
		$query = array( 'email' => $results["email"] );
		$doc = $IRB->findOne($query);		
		if(!is_null($doc)) {
			// email already registered!			
			echo '<p>Hmm...It seems that email address ('.$results["email"].') has already been registered with the IRB. You might try <a href="index.php">logging in</a>, or if you have forgotten your password, you can reset it by clicking <a href="'.$_SERVER["PHP_SELF"].'?reset=true&email='.$results["email"].'">here</a>.</p></div></div></div></div></body></html>';
			$client -> close();
			die();
		} else {
			// email has not been registered; add to database
			$feedback = '';
			if($IRB -> insert($results)) { // adding new registration
				$feedback .= '<p>Thank you! Your information has been recorded in the IRB database.</p>';
				
// TESTING!!! 
				$test = $IRB->findOne(array('email' => $results["email"]));
				print_r($test);
// END TESTING


				$client -> close(); // close connection
				// send email to new registrant
				$subject = "HC IRB email verification";					
				$message = '<html><body style="font-family: Georgia,Serif">';
				$message .= '<p>This is an automatic email sent from the Hanover College IRB database. We received a registration request for this email address ('.$email.'). To complete the registration, please click the link below (or copy and paste it into your browser). If you did not submit a registration request, please disregard this notice. If you have any questions, you may contact the webmaster for the IRB, Bill Altermatt, at altermattw@hanover.edu or the chair of the IRB, Dean Jacks, at jacks@hanover.edu.</p>';
				$message .= '<p><a href="http://vault.hanover.edu/~altermattw/dev/IRB/logReg.php?email='.$email.'&hash='.$results["hash"].'"">Click this link to confirm registration</a></p>';
				$message .= '</body></html>';					

				if(mail($email,$subject,$message,$headers)) {
	          $feedback .= '<p>An email message has been sent to '.$email.'. Please check your email and click the link in the email to verify your email address and finalize your registration.</p></div></div></div></div></body></html>';
	          echo $feedback;
	          die();
	        } else {
	        	$feedback .= '<p>There was a problem sending the verification email to '.$email.'. Please check the address to make sure it is correct and <a href="register.html">try again</a>. If you continue to have problems, please contact the IRB webmaster, Bill Altermatt, at altermattw@hanover.edu. Sorry for the inconvenience.</p></div></div></div></div></body></html>';
	        	echo $feedback;
	        	die();
	      }
			} else {
				echo '<p>There was a problem adding your records to the IRB database. Please <a href="register.html">try again</a> or contact the webmaster, Bill Altermatt, at altermattw@hanover.edu. Sorry for the inconvenience.</p></div></div></div></div></body></html>';
				die();
			}
		}		
	} // end first-time registration	

	// receiving email verification for registration
	if(isset($_GET["hash"])) {
		if(!isset($_GET["email"])) {
			echo '<p>No email address accompanied that verification request. Please contact the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu.</p>';
			die();
		} else {
			$hash = (string) $_GET["hash"];
			$email = (string) $_GET["email"];
			$client = new MongoClient($uri, $options );
			$db = $client->selectDB($database);
			$IRB = $db->IRB; // accessing collection
			// check to see if someone with that email address is already registered
			$query = array( 'email' => $email );
			$fields = array( 'hash' => $hash );
			$doc = $IRB->findOne($query,$fields);		
			if(is_null($doc)) {
				echo '<p>Sorry, but we were unable to find your email address in the records. Check your email to see if you received a more recent link. If you continue to have problems, contact the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu.</p></div></div></div></div></body></html>';
				die();
			} else {
				if($doc['hash'] === $hash) {
					echo '<p>Success! Your email address has been verified.</p>';
					// TODO: add 'verified' to record
					$query = array( 'email' => $email);
					$update = array( 'verified' => 'true' );
					if($IRB->update($query,$update)) {
						echo '<p>You can now access your account by <a href="index.php">logging in</a>.</p></div></div></div></div></body></html>';
						$client->close();
						die();
					} else {
						echo '<p>Uh-oh. There was a problem updating your account to email-verified status. Please contact the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu.</p></div></div></div></div></body></html> ';
						$client->close();
						die();
					}					
				} else {
					echo '<p>Sorry, but the verification code does not match the one in the records. Check your email to see if you received a more recent link. If you continue to have problems, contact the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu.</p></div></div></div></div></body></html>';
					$client->close();
					die();
				}
			}
		}
	}

	// check login and password
	if(isset($_POST["email"]) && isset($_POST["password"])) {
		function isEqual($str1, $str2) // used for constant-time string compare (to prevent timing attacks)
		{
		    $n1 = strlen($str1);
		    if (strlen($str2) != $n1) {
		        return false;
		    }
		    for ($i = 0, $diff = 0; $i != $n1; ++$i) {
		        $diff |= ord($str1[$i]) ^ ord($str2[$i]);
		    }
		    return !$diff;
		}
		$password = (string) $_POST["password"];
		$email = (string) $_POST["email"];
		$client = new MongoClient($uri, $options );
		$db = $client->selectDB($database);
		$IRB = $db->IRB; // accessing collection
		// check to see if someone with that email address is already registered
		$query = array( 'email' => $email );
		$fields = array( 'password' => true, 'verified' => true);
		$doc = $IRB->findOne($query, $fields);
		if (!is_null($doc)) {	// email is in database
// TESTING!
			print_r($doc);
// END TESTING
			if($doc['verified'] === 'true') { // email address has been verified
				$given_password = $password; // the submitted password
				$db_hash = $doc['password']; // field with the password hash
				$given_hash = crypt($given_password, $db_hash);
				if (isEqual($given_hash, $db_hash)) {
				  echo "Password matches!  Hurray!";
				    // user password verified
						// TODO: offer link to user dashboard page		
				} else {
						// password does not match
				//TODO: check if there is an 'attempts' record for this user.
				// attempts is an array of MongoDates, which are stored as ms past the epoch
				// attempts stores only the last 10 attempts. If there are more than 10, the earliest is replaced.
				// On a failed password match:  
				// 1. add a new MongoDate() to attempts
				// 2. count how many MongoDates are < 24 hours old.
				// 3. if all 10 are < 24 hours old, then:
					// a. alert the administrator
					// b. send an email to the user asking what's going on, provide link to reset password
					// c. temporarily lock the account
				
				echo '<p>The user name or password was incorrect. Please <a href="index.php">try again</a>.</p>/div></div></div></div></body></html>';
				$client->close();
				die();
				}

			}	else { // email has not yet been verified
				echo '<p>Your account has not yet been verified through email. Check your email for a message from do-not-reply@hanover.edu with the subject line &ldquo;HC IRB email verification&rdquo;. That message should contain a link that you can click to verify your account by email. If you continue to have problems, please contact the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu</p></div></div></div></div></body></html>';
				$client->close();
				die();
			}
			
		} else { // email is not in database
			echo '<p>That email address was not found. Please check the spelling and try <a href="index.php">logging in</a> again. If you have not yet registered, you will need to do that before you can log in. <a href="register.html">Click here</a> to register a new account. If you continue to have trouble, please email the HC IRB webmaster, Bill Altermatt, at altermattw@hanover.edu.</p>';
			$client->close();
			die();
		}
	}

?>