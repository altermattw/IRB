<?php
	if (!isset($_SESSION)) {session_start(); }
// constants
	// $IRBchair = array("name" => "Dean Jacks", "email" => "jacks@hanover.edu");
	$IRBchair = array("name" => "Bill Altermatt", "email" => "altermattw@hanover.edu");
	$IRBwebmaster = array("name" => "Bill Altermatt", "email" => "altermattw@hanover.edu");

	function getChair() {
		return array("name" => "Dean Jacks", "email" => "jacks@hanover.edu");
	}

	function getWM() {
		return array("name" => "Bill Altermatt", "email" => "altermattw@hanover.edu");
	}

	// tables
		// users:  registration info
		// year2015, year2016, etc.:  applications

// MySQL UTILITIES

	function myConnect() {
		// Function to connect to a database and return the connection
		// Usage:  $mysqli = myConnect();
		include('mysql_config.php');
		$mysqli = new mysqli('localhost', 'altermattw', $password, 'altermattw');
		if ($mysqli->connect_error) {
			die('Connect Error(' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}
		return $mysqli;
	}

	function resultToArray($result) { // returns an array of arrays, 1 for each row of data
	    $rows = array();
	    while($row = $result->fetch_assoc()) {
	        $rows[] = $row;
	    }
	    return $rows;
	}

	function userExists($email,$mysqli) {
		$query = 'SELECT 1 FROM users WHERE email="'.$email.'"';
		if ($result = $mysqli->query($query)) {

		    /* determine number of rows result set */
		    if($result->num_rows > 0) {
		    	return TRUE;
		    } else {
		    	return FALSE;
		    }
		    /* close result set */
		    $result->close();
		} else {
			return FALSE;
		}
	}

	function mailVerification($email,$hash) {
		$chair = getChair();
		$WM = getWM();
		$headers = 'From: do-not-reply@hanover.edu' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
		$subject = "HC IRB email verification";
		$message = '<html><body style="font-family: Arial,Serif">';
		$message .= '<p>This is an automatic email sent from the Hanover College IRB database. We received a registration request for this email address ('.$email.'). To complete the registration, please click the link below (or copy and paste it into your browser). If you did not submit a registration request, please disregard this notice. If you have any questions, you may contact the webmaster for the IRB, '.$WM["name"].', at '.$WM["email"].' or the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
		$message .= '<p><a href="http://irb.hanover.edu/verify.php?email='.$email.'&hash='.$hash.'">Click this link to confirm registration</a></p>';
		$message .= '</body></html>';
		$feedback = "";
		if(mail($email,$subject,$message,$headers)) {
         $feedback = '<p>An email message has been sent to '.$email.'. Please check your email and click the link in the email to verify your email address and finalize your registration. <strong>You may need to check your Junk or Clutter folders.</strong></p>';
		} else {
			$feedback = '<p>There was a problem sending the verification email to '.$email.'. Please check that address to make sure it is correct and <a href="register.html">try again</a>. If you continue to have problems, please contact the IRB webmaster, '.$WM["name"].' at '.$WM["email"].'. Sorry for the inconvenience.</p>';
		}
		return $feedback;
	}

	function mailMessage($email,$subject,$msg) {
		$headers = 'From: IRB-do-not-reply@hanover.edu' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
		$message = '<html><body style="font-family: Arial,Serif">';
		$message .= $msg;
		$message .= '</body></html>';
		if(mail($email,$subject,$message,$headers)) {
         return TRUE;
		} else {
			// FOR TESTING ONLY
			echo '<p>Problem sending email. Text of email follows.</p>';
			echo '<p>To: '.$email.'</p>';
			echo '<p>Subject: '.$subject.'</p>';
			echo '<p>'.$headers.'</p>';
			echo '<p>'.$message.'</p>';
			return FALSE;
		}
	}

	function getUserRecord($email,$mysqli) {
		$email = mysqli_escape_string($mysqli,$email);
		$query = 'SELECT * FROM users WHERE email="'.$email.'"';
		if ($result = $mysqli->query($query)) {
			$row = mysqli_fetch_assoc($result);
			return $row; // returns an associative array
		} else {
			return FALSE;
		}
	}

	function getAuthors($mysqli,$studyNumbers) {
		$studyImplode = implode(", ",$studyNumbers);
		$query = 'SELECT * FROM userapps WHERE studyNumber IN ('.$studyImplode.')';
		if ($result = $mysqli->query($query)) {
			$data = resultToArray($result); // gathers up all the rows, not just one
			$studyNums = array();
			$titles = array();
			foreach($data as $key => $row) {
				$studyNums[$key] = $row['studyNumber'];
				// $titles[$key] = $row['title'];
			}
			array_multisort($studyNums, SORT_ASC, $data);
			return $data;
		}
	}

if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( ! isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( ! isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}

	function hasAccess($mysqli,$email,$studyNumber) {
		return TRUE;
		//$query = 'SELECT email FROM userapps WHERE studyNumber='.$studyNumber;
		//if ($result = $mysqli->query($query)) {
			//$data = resultToArray($result);
			//if(array_search($email,array_column($data,'email'))) {
				//return TRUE;
			//} else {
				//return FALSE;
			//}
		//}
	}

	function getTitles($mysqli,$studyNumbers) {
		// $studyNumbers is an array of study numbers: [2015002, 2015004]
		// returns an array of arrays: [[studyNumber=>2015002,title=>'My study'],[studyNumber=>2016001,title=>'Another study']]
		if(count($studyNumbers) < 1) return 0;
		$tableNames = array(); // will be array of tableNames ['year2015','year2016',etc.]
		foreach($studyNumbers as $studyNumber) {
			$studyNumber = mysqli_escape_string($mysqli,$studyNumber);
			$tableNames[] = 'year'.substr($studyNumber,0,4);
		}
		$tableNames = array_unique($tableNames); // removes duplicates
		$studyImplode = implode(", ",$studyNumbers);
		$queryArr=array();
		foreach($tableNames as $tableName) {
			$queryArr[] = '(SELECT studyNumber, title FROM '.$tableName.' WHERE studyNumber IN ('.$studyImplode.'))';
		}
		$query = implode(" UNION ",$queryArr); // joins queries together with 'UNION' clause
		if ($result = $mysqli->query($query)) {
			$data = resultToArray($result); // gathers up all the rows, not just one
			$studyNums = array();
			$titles = array();
			foreach($data as $key => $row) {
				$studyNums[$key] = $row['studyNumber'];
				$titles[$key] = $row['title'];
			}
			array_multisort($studyNums, SORT_ASC, $data);
			return $data;
		}
	}

	function getAppRecord($mysqli,$studyNumber) {
		// Retrieves the complete record for a single study.
		$studyNumber = mysqli_escape_string($mysqli,$studyNumber);
		$tableName = 'year'.substr($studyNumber,0,4);
		$query = 'SELECT * from '.$tableName.' WHERE studyNumber='.$studyNumber.';';
		$apps = array();
		if ($result = $mysqli->query($query)) {
			$rows = resultToArray($result); // gathers up all the rows, not just one
			foreach($rows as $row) {
				$apps[] = $row;
			}
			$app = $apps[0]; // just the first one has the application data
			// now, get author and sponsor information
			$query = 'SELECT * from userapps WHERE studyNumber='.$studyNumber.';';
			if ($result = $mysqli->query($query)) {
				$rows = resultToArray($result); // gathers up all the rows, not just one
				$i=1;
				foreach($rows as $row) {
					if($row["role"]=="author") {
						$nameLabel = '5Author'.$i.'A';
						$emailLabel = '5Author'.$i.'D';
						$app[$nameLabel]=$row["name"];
						$app[$emailLabel]=$row["email"];
						$i++; // next one will be one higher
					} else {
						if($row["role"]=="sponsor") {
							$app["sponsorName"]=$row["name"];
							$app["sponsorEmail"]=$row["email"];
						} else {
							if($row["role"]=="IRB") {
								$app["IRBname"]=$row["name"];
								$app["IRBemail"]=$row["email"];
							}
						}
					}
				}
			return $app;
			} else {
			return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	function revisionRequest($mysqli,$studyNumber,$title,$status,$approved,$comments,$message) {
		// $approved is an array of the structure received from getApprovalStatus()
		// $status is what the status of the study will be changed to
		$okayStatus = array("Co-author Revision","Faculty Sponsor Revision","IRB Revision");
		if(in_array($status,$okayStatus)) {
			if(getCurrentStatus($mysqli,array($studyNumber)) != $status) {
				if(setStatus($mysqli,$studyNumber,$status,$_SESSION["userid"],$comments)) {
					$message.='<p>Status changed to &ldquo;'.$status.'&rdquo;</p>';
					// email everybody
					// add $statusArray that translates $status into a phrase that fits into "has now been..."
					$newStatus=$status;
					$nextStep='The next step is for the authors to log in to <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a> and revise the application based on the comments from the IRB. When you are finished with the revision, you can resubmit the application. It will then be considered for approval by any co-authors or faculty sponsor before being sent back to the IRB for review. ';
					if($comments!="") {
						$nextStep.='The comments made by the IRB are as follows: </p><p>'.$comments.'</p><p>';
					}
					foreach($approved as $key=>$val) {
						if($key=='authors') {
							foreach($val as $key2=>$val2) {
								if(confirmationEmail($key2,$studyNumber,$title,"author",$newStatus,$nextStep)) {
									$message.='<p>Confirmation email sent to '.$key2.'.</p>';
								} else {
									$message.='<p>Error sending email to '.$key2.'. Email not sent.</p>';
								}
							}
						} else { // key is either IRB or sponsor
							if($status=='IRB Revision' || ($status=='Faculty Sponsor Revision' && $key=='sponsor')) { // email faculty member
								$to=current(array_keys($val));
								if(confirmationEmail($to,$_SESSION["studyNumber"],$title,$key,$newStatus,$nextStep)) {
									$message.='<p>Confirmation email sent to '.$to.'.</p>';
								} else {
									$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
								}
							}
						}
					}
				} else {
					// error message
					$WM = getWM();
					$message.='<p>Sorry, but there was a problem updating the status of the application to &ldquo;'.$status.'&rdquo;. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this error message.</p>';
				}
			} else {
				$message.='<p>Current status is already set to '.$status.'. Status not changed.</p>';
			}
		} else {
			$message.='<p>Sorry, the revisionRequest function failed because the requested status change was not a revision status.</p>';
		}
		return $message;
	}

	function getApprovalStatus($mysqli,$studyNumber) {
			// 1. determines each person who *would* need to approve the app (all co-authors, faculty sponsor, IRB)
			// 2. checks each of those people to see if they HAVE approved it
			// 3. returns an array:  array("authors" => array("co-author1 email" => time of approval, "co-author2 email" => 0), "sponsor" => array("faculty sponsor email" => 0), "IRB" => array("IRB reviewer email" => 0);
		$allStatus = getStatus($mysqli,array($studyNumber),FALSE); // an array of all the status updates for this application
		// $currentStatus = $allStatus[0]["status"]; // most recent status update
		// find the time of the most recent "revision" ("First Draft", "Co-Author Revision", "Faculty Sponsor Revision", "IRB Revision")
			// a revision "destroys" all the previous approvals, so don't even look at any approvals prior to a revision
		$people = getAuthors($mysqli,array($studyNumber)); // array of arrays of authors, sponsor, and IRB reviewer
		$approved = array();
		foreach($people as $person) { // populating the array that will be returned
			if($person["role"]=="author") {
				$approved["authors"][$person["email"]] = 0;
			}
			if($person["role"]=="sponsor") {
				$approved["sponsor"][$person["email"]] = 0;
			}
			if($person["role"]=="IRB") {
				$approved["IRB"][$person["email"]] = 0;
			}
		}
		$lastTime = 0;
		$oldStatus = array_reverse($allStatus); // from oldest to newest
		foreach($oldStatus as $status) {
			if ((strpos($status["status"],'Revision') !== false) || ($status["status"] == "First Draft")) { // if status contains the word "Revision" or is "First Draft"
			    $lastTime = intval($status["time"],10);
			}
		} // there should now be a $lastTime because every app at least has a "First Draft" status
		foreach($oldStatus as $status) { // over-writing the $approved array with any approvals that have come in
			if(intval($status["time"],10) >= $lastTime) { // if the status update is AFTER the last revision
				if($status["status"] == "Co-author Approval") { // Add that approving co-author to $approved
					$approved["authors"][$status["email"]] = $status["time"];
				}
				if($status["status"] == "Faculty Sponsor Approval") {
					$approved["sponsor"][$status["email"]] = $status["time"];
				}
				if($status["status"] == "IRB Approval") {
					$approved["IRB"][$status["email"]] = $status["time"];
				}
			}
		}
		return $approved;
	}

	function computeCurrentStatus($mysqli,$studyNumber) {
		// $studyNumber is just one number
		// "First Draft","Submitted to Co-authors","Co-author Approval","Co-author Revision","Submitted to Faculty Sponsor","Faculty Sponsor Revision","Submitted to IRB","IRB Revision","IRB Approval","Withdrawn"
		$status="";
		$approval = getApprovalStatus($mysqli,$studyNumber);
		$statusHistory = getStatus($mysqli,array($studyNumber));
			// returns array of array(studyNumber=>2015002,status=>"First Draft",email=>"altermattw@hanover.edu",time=>1441673156,comments=>"blah blah")
		$firstDraft = TRUE;
		if(count($statusHistory)>1) $firstDraft = FALSE; // more than 1 entry in status history => not first draft
		if(current($approval["IRB"])>0) { // IRB has approved
			$status = "IRB Approval";
		} else {
			if(isset($approval["sponsor"])) { // there is a faculty sponsor
				if(current($approval["sponsor"])>0) { // fac sponsor has approved
					$status = "Submitted to IRB";
				} else { // sponsor has not yet approved
					if(array_product($approval["authors"]) != 0) { // all co-authors have approved
						$status = "Submitted to Faculty Sponsor";
					} else { // some co-authors have not approved
						if(array_sum($approval["authors"]) > 0) { // at least one has approved
							$status = "Submitted to Co-authors";
						} else { // not even one author has approved; it is in First Draft or revision
							$status = $statusHistory[0]["status"];
						}
					}
				}
			} else { // there is no faculty sponsor
				if(array_product($approval["authors"]) != 0) { // all co-authors have approved
						$status = "Submitted to IRB";
				} else { // some co-authors have not approved
					if(array_sum($approval["authors"]) > 0) { // at least one has approved
						$status = "Submitted to Co-authors";
					} else { // not even one author has approved; it is in First Draft or revision
						$status = $statusHistory[0]["status"];
					}
				}
			}
		}
		return $status;
	}


	function getStudyNumbers($mysqli,$email,$role="any") {
		// $mysqli is the result of the myConnect() function
		// $email an email address
		// $role is "author", "sponsor", "IRB", or "any"
		$query = 'SELECT * FROM userapps WHERE email="'.$email.'"';
		if($role!="any") $query.= ' AND role="'.$role.'";';
		$apps = array();
		if ($result = $mysqli->query($query)) {
			$rows = resultToArray($result); // gathers up all the rows, not just one
			foreach($rows as $row) {
				$apps[] = $row["studyNumber"];
			}
		}
		sort($apps);
		return $apps; // returns an array of studyNumbers (e.g., 2015001)
	}

	function getStudies($mysqli,$email) {
		// $mysqli is the result of the myConnect() function
		// $email an email address
		// $role is "author", "sponsor", "IRB", or "any"
		$query = 'SELECT studyNumber FROM userapps WHERE email="'.$email.'"';
		$apps = array(); // will be an array of studyNumbers
		if ($result = $mysqli->query($query)) {
			$rows = resultToArray($result); // gathers up all the rows, not just one
			foreach($rows as $row) {
				$apps[] = $row["studyNumber"];
			}
			$studyImplode = implode(", ",$apps);
			// get Titles, class information from 'year20xx'
				// need to look in different tables depending on studyNumber
				// $query = 'SELECT studyNumber,title,courseDept,courseNum FROM year2016 WHERE studyNumber IN ('.$studyImplode.')';


			$query = 'SELECT studyNumber,status,time FROM current WHERE studyNumber IN ('.$studyImplode.')';
			if ($result = $mysqli->query($query)) {
				$rows = resultToArray($result); // each row has studyNumber, status, and time
				$out = array();
				$times = array();
				foreach($rows as $row) {
					$out[$row["studyNumber"]] = array("studyNumber" => $row["studyNumber"], "status" => $row["status"], "time" => $row["time"]);
					$times[] = $row["time"];
				}
			}
			$query = 'SELECT * FROM userapps WHERE studyNumber IN ('.$studyImplode.')'; // gets ALL the authors, sponsors, IRBers with those studyNumbers
			if ($result = $mysqli->query($query)) {
				$data = resultToArray($result); // gathers up all the rows, not just one
				$results = array();
				foreach($data as $datum) {
					$lastName1 = explode(" ",trim($datum["name"])); // splits name into pieces by spaces
					$lastName2 = count($lastName1)-1; // counts number of name pieces, minus 1
					$lastName = $lastName1[$lastName2]; // gets last name piece
					$out[$datum["studyNumber"]][$datum["role"]][$datum["email"]] = $lastName;

				}
				array_multisort($times, SORT_ASC, $out);
				return $out;
			}
		}
	}


	function postToResults($accepted) {
		// $accepted is an array of accepted variable names, used to screen $_POST
		// returns a named array of data from $_POST that matches accepted values
		// used to guard against injection attacks by only accepting some variables
		$results = array();
		foreach ( $_POST as $foo=>$bar ) {
	    if ( in_array( $foo, $accepted) && $bar!="" ) {
	        $results[$foo] = $bar;
		    }
		}
		return $results;
	}

	function putRecords($mysqli, $tableName, $data) {
		// adds records to $tableName
		// $data is a named array, with keys = variable name and values = data from one person
		// first check to see if the table exists
		$val = mysqli_query($mysqli, 'select 1 from '.$tableName);
		if($val == TRUE) // TABLE DOES EXIST. ADD DATA TO IT.
		{
			foreach($data as &$p) {
				$p = mysqli_real_escape_string($mysqli,$p);
				if(!is_numeric($p)) $p = '"'.$p.'"';
			}

		// Comma-separating the header and data info for use in command
			$dataKeys = array_keys($data);
	  		$keyImplode = implode(", ",$dataKeys);
			$dataImplode = implode(", ",$data);

		// Add new data to table
			$sql = 'INSERT INTO '.$tableName.' ('.$keyImplode.') VALUES ('.$dataImplode.')';
			if(!mysqli_query($mysqli,$sql)) {
				echo '<p>Sorry! There was a problem recording your data. Please contact the webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].', and tell him the error code printed below so he can fix it. Thanks!</p>';
				echo '<p>Error: '.mysqli_error($mysqli).'</p>';
			}
		}
	}

	function createTable($mysqli, $tableName) {
		$query = "CREATE TABLE IF NOT EXISTS ".$tableName. "(
			studyNumber INT(11) NOT NULL AUTO_INCREMENT,
			title VARCHAR(150) NOT NULL,
			versionNumber TINYINT(4) NOT NULL DEFAULT '1',
			versionEmail CHAR(8) NULL DEFAULT NULL,
			authorNames VARCHAR(1000) NULL DEFAULT NULL,
			authorEmails VARCHAR(1000) NULL DEFAULT NULL,
			dateCreated INT(11) NULL DEFAULT NULL,
			dateLastSaved INT(11) NULL DEFAULT NULL,
			authorApprovals VARCHAR(500) NULL DEFAULT NULL,
			authorFeedback TEXT NULL,
			sponsorName VARCHAR(100) NULL DEFAULT NULL,
			facultyProject VARCHAR(3) NULL DEFAULT NULL COMMENT 'on=faculty project',
			sponsorEmail VARCHAR(100) NULL DEFAULT NULL,
			sponsorApproval INT(11) NULL DEFAULT NULL,
			sponsorFeedback TEXT NULL,
			courseDept VARCHAR(5) NULL DEFAULT NULL,
			courseNum SMALLINT(3) NULL DEFAULT NULL,
			IRBapproval INT(11) NULL DEFAULT NULL,
			IRBreviewers VARCHAR(1000) NULL DEFAULT NULL,
			IRBfeedback TEXT NULL,
			forClass TINYINT(1) NULL DEFAULT NULL COMMENT '0=not for class, 1=for class',
			briefDescrip TEXT NULL,
			maxMinutes INT(11) NULL DEFAULT NULL,
			multiSession TINYINT(1) NULL DEFAULT NULL,
			multiSessionExp TEXT NULL,
			sampleSize SMALLINT(6) NULL DEFAULT NULL,
			recruitPersonal VARCHAR(3) NULL DEFAULT NULL,
			recruitExtra VARCHAR(3) NULL DEFAULT NULL COMMENT 'on=extra credit in class',
			recruitSocialMedia VARCHAR(3) NULL DEFAULT NULL,
			recruitGroup VARCHAR(3) NULL DEFAULT NULL,
			recruitGroupText TEXT NULL,
			recruitRandom VARCHAR(3) NULL DEFAULT NULL,
			recruitOther VARCHAR(3) NULL DEFAULT NULL,
			recruitOtherText TEXT NULL,
			recruitNot VARCHAR(3) NULL DEFAULT NULL COMMENT 'on=naturalistic obs or field study',
			infConsent TINYINT(1) NULL DEFAULT NULL COMMENT '1=yes, informed consent',
			infConsentText TEXT NULL,
			waiveArchival VARCHAR(3) NULL DEFAULT NULL,
			waiveFieldStudy VARCHAR(3) NULL DEFAULT NULL,
			waiveJeopardize TEXT NULL,
			waivePublicOffic VARCHAR(3) NULL DEFAULT NULL,
			waiveOther VARCHAR(3) NULL DEFAULT NULL,
			waiveOtherText TEXT NULL,
			debriefing TINYINT(1) NULL DEFAULT NULL COMMENT '1=yes, debriefing',
			debriefText TEXT NULL,
			whyNoDebriefText TEXT NULL,
			links TEXT NULL,
			otherFiles TEXT NULL,
			infConsSig TINYINT(1) NULL DEFAULT NULL,
			infConsRisk TINYINT(1) NULL DEFAULT NULL,
			infConsRiskText TEXT NULL,
			otherInfConsent TEXT NULL,
			uniqueID TINYINT(1) NULL DEFAULT NULL,
			uniqueIDtext TEXT NULL,
			uniqueIDhandling TEXT NULL,
			uniqueLinked TINYINT(1) NULL DEFAULT NULL,
			publicDisclose TEXT NULL,
			responseRisk TINYINT(1) NULL DEFAULT NULL,
			confidentialityText TEXT NULL,
			exceedsMinRisk TINYINT(1) NULL DEFAULT NULL,
			exceedsMinRiskText TEXT NULL,
			privacyProblem TINYINT(1) NULL DEFAULT NULL,
			privacyExplain TEXT NULL,
			deception TINYINT(1) NULL DEFAULT NULL,
			deceptionExplain TEXT NULL,
			objectionable TINYINT(1) NULL DEFAULT NULL,
			objectionableText TEXT NULL,
			sensitiveQ TINYINT(1) NULL DEFAULT NULL,
			sensitiveText TEXT NULL,
			women TINYINT(1) NULL DEFAULT NULL,
			pregnantRisk TINYINT(1) NULL DEFAULT NULL,
			pregnantExplain TEXT NULL,
			children VARCHAR(3) NULL DEFAULT NULL,
			incarcerated VARCHAR(3) NULL DEFAULT NULL,
			mentallyDisabled VARCHAR(3) NULL DEFAULT NULL,
			disadvantaged VARCHAR(3) NULL DEFAULT NULL,
			otherParticipants VARCHAR(3) NULL DEFAULT NULL,
			otherParticipantsText TEXT NULL,
			survey VARCHAR(3) NULL DEFAULT NULL,
			interview VARCHAR(3) NULL DEFAULT NULL,
			educationalTests VARCHAR(3) NULL DEFAULT NULL,
			publicBehavior VARCHAR(3) NULL DEFAULT NULL,
			oralHistory VARCHAR(3) NULL DEFAULT NULL,
			focusGroup VARCHAR(3) NULL DEFAULT NULL,
			programEvaluation VARCHAR(3) NULL DEFAULT NULL,
			humanFactors VARCHAR(3) NULL DEFAULT NULL,
			qualityAssurance VARCHAR(3) NULL DEFAULT NULL,
			archival TINYINT(1) NULL DEFAULT NULL,
			archivalSource TEXT NULL,
			archivalPublic TINYINT(1) NULL DEFAULT NULL,
			archivalNotAnonymous TINYINT(1) NULL DEFAULT NULL,
			educationalSetting TINYINT(1) NULL DEFAULT NULL,
			publicOfficials TINYINT(1) NULL DEFAULT NULL,
			benefitPrograms TINYINT(1) NULL DEFAULT NULL,
			foodQuality TINYINT(1) NULL DEFAULT NULL,
			wholesomeFood TINYINT(1) NULL DEFAULT NULL,
			lowAdditives TINYINT(1) NULL DEFAULT NULL,
			classified TINYINT(1) NULL DEFAULT NULL,
			drugStudy TINYINT(1) NULL DEFAULT NULL,
			newIndication TINYINT(1) NULL DEFAULT NULL,
			labelChange TINYINT(1) NULL DEFAULT NULL,
			changeAdvertising TINYINT(1) NULL DEFAULT NULL,
			drugIncreaseRisk TINYINT(1) NULL DEFAULT NULL,
			drugInfConsent TINYINT(1) NULL DEFAULT NULL,
			drugNoPromote TINYINT(1) NULL DEFAULT NULL,
			drugNoDistribute TINYINT(1) NULL DEFAULT NULL,
			drugNoProlong TINYINT(1) NULL DEFAULT NULL,
			devicesStudy TINYINT(1) NULL DEFAULT NULL,
			deviceApproved TINYINT(1) NULL DEFAULT NULL,
			deviceRisk TINYINT(1) NULL DEFAULT NULL,
			deviceInVitro TINYINT(1) NULL DEFAULT NULL,
			deviceNonInvasive TINYINT(1) NULL DEFAULT NULL,
			deviceEnergy TINYINT(1) NULL DEFAULT NULL,
			deviceDiagnose TINYINT(1) NULL DEFAULT NULL,
			devicePreference TINYINT(1) NULL DEFAULT NULL,
			deviceEffectiveness TINYINT(1) NULL DEFAULT NULL,
			deviceVeterinary TINYINT(1) NULL DEFAULT NULL,
			deviceLabAnimals TINYINT(1) NULL DEFAULT NULL,
			deviceCustom TINYINT(1) NULL DEFAULT NULL,
			deviceCommercial TINYINT(1) NULL DEFAULT NULL,
			blood TINYINT(1) NULL DEFAULT NULL,
			bloodParticipants TINYINT(1) NULL DEFAULT NULL,
			blood550ml TINYINT(1) NULL DEFAULT NULL,
			blood3ml TINYINT(1) NULL DEFAULT NULL,
			bloodFreq TINYINT(1) NULL DEFAULT NULL,
			bloodLicense TINYINT(1) NULL DEFAULT NULL,
			indGroup TINYINT(1) NULL DEFAULT NULL,
			indGroupExp TEXT NULL,
			surveyInterview TINYINT(1) NULL DEFAULT NULL,
			specimens TINYINT(1) NULL DEFAULT NULL,
			specimensExp TEXT NULL,
			kinesiology TINYINT(1) NULL DEFAULT NULL,
			kinesiologyExp TEXT NULL,
			recordings TINYINT(1) NULL DEFAULT NULL,
			recordingsExp TEXT NULL,
			PRIMARY KEY (studyNumber)
			)
			COLLATE='latin1_swedish_ci'
			ENGINE=InnoDB
			AUTO_INCREMENT=".substr($tableName, -4)."001";
		if(!mysqli_query($mysqli,$query)) {
			$WM = getWM();
			mailMessage($WM["email"],'Problem creating new table','<p>There was a problem creating a new database table to store responses.</p><p>Syntax: '.$query.'</p><p>Error: '.mysqli_error($mysqli).'</p>');
			echo '<p>Oops.  There was a problem creating a new database table to store your application information. Please email the webmaster, '.$WM["name"].', at '.$WM["email"].' with the following information: </p><p>Syntax: '.$query.'</p><p>Error: '.mysqli_error($mysqli).'</p>';
		}
	}

	function updateApp($mysqli, $user, $tableName, $data) {
		// $data may include studyNumber, in which case that record is updated, or it may not, in which case a new studyNumber is assigned.
		// $user is the person logged in at the time
		// Should return studyNumber if the update was successful, and FALSE if not
		// Step 1: Does the table exist?
		$studyNumber = "";
		if(isset($data["studyNumber"])) {// studyNumber has already been set
			$studyNumber = $data["studyNumber"];
			$currentStatus = computeCurrentStatus($mysqli,$studyNumber);
			$lockedStatus = array("Submitted to Co-authors","Co-author Approval","Submitted to Faculty Sponsor","Submitted to IRB","IRB Approval","Withdrawn");
			if(in_array($currentStatus, $lockedStatus)) {
				return FALSE; // prevents an application that is in a review phase from being modified
			}
		}
		if(isset($_POST["lockStatus"])) {
			if($_POST["lockStatus"] == "locked") {
				echo '<h1>Locked!</h1>';
				return FALSE; // prevents processing of form that is locked
			}
		} else {
			return FALSE; // prevents processing of form that is locked
		}
		$val = mysqli_query($mysqli, 'select 1 from '.$tableName);
		if(!$val) { // table does not exist. Perhaps it is a new year?
			createTable($mysqli,$tableName);
		}

		if($val == TRUE && isLoggedIn()) { // Table does exist and user is logged in.
			$command = array();
			$records = array(); 	// will hold email,name,role for export to updateUserApps
										// [1=>[email,role,name],2=>[email,role,name],"sponsor"=>[email,role,name]]
			foreach($data as $key => &$val) {
				$val = mysqli_real_escape_string($mysqli,$val);
				if(!is_numeric($val)) $val = '"'.trim($val).'"'; // trim() removes whitespace from the beginning and end

				// identifying author and sponsor emails
					if(substr($key,0,7) == '5Author'){
						preg_match('/(?<=Author)\d{1,2}/',$key,$matches); // captures the author number, stored in $matches
						$i=$matches[0];
						if(substr($key,-1,1) == 'D') {
							$val = strtolower($val);
							$records[$i]["email"]=$val;
							$records[$i]["role"]='"author"';
						}
						if(substr($key,-1,1) == 'A') {
							$records[$i]["name"]=$val;
						}
						unset($data[$key]); // removes this from $data
					} else {
						if($key == 'sponsorEmail' && $val != "") {
							$val = strtolower($val);
							$records["sponsor"]["email"]=$val;
							$records["sponsor"]["role"]='"sponsor"';
							unset($data[$key]); // removes this from $data
						} else {
							if($key == 'sponsorName' && $val != "") {
								$records["sponsor"]["name"]=$val;
								unset($data[$key]); // removes this from $data
							} else {
								// Ready the UPDATE part of the query
								$command[] = $key.'='.$val;
							}
						}
					}
				}

			// print_r($records);// for debugging only

			// Ready the INSERT part of the query
				$data['dateCreated'] = time(); // Add dateCreated to the INSERT language
				$dataKeys = array_keys($data);
	  			$keyImplode = implode(", ",$dataKeys);
				$dataImplode = implode(", ",$data);
		// Add new data to table
			$sql = 'INSERT INTO '.$tableName.' ('.$keyImplode.') VALUES ('.$dataImplode.')';
			$commImplode = implode(", ",$command); // comma-separated
			$commImplode .= ', dateLastSaved='.time(); // dateLastSaved will be updated only on UPDATE, not on INSERT
			$sql .= ' ON DUPLICATE KEY UPDATE '.$commImplode;
			// echo '<p>'.$sql.'</p>';	// for debugging
			if(!mysqli_query($mysqli,$sql)) {
				$WM = getWM();
				echo '<p>Sorry! There was a problem recording your data. Please contact the webmaster, '.$WM["name"].', at '.$WM["email"].' and tell him the syntax and error code printed below so he can fix it. Thanks!</p>';
				echo '<p>Syntax: '.$sql.'</p>';
				echo '<p>Error: '.mysqli_error($mysqli).'</p>';
			} else { // If the insertion was successful
				$studyNumber = mysqli_insert_id($mysqli); // getting study number
				// If there are names & emails of authors and sponsor, update the userapps DB
					if(count($records) > 0 && mysqli_insert_id($mysqli) > 0) {

						// how is $records being filled when the user isn't on page 1?
						// could updateUserApps be triggered even when no author info is coming in?

						// if no IRB role has been set, add it to records
						$IRBregistered = getRoleEmails($mysqli,$studyNumber,"IRB");

						if(empty($IRBregistered)) { // no IRB role set for this app
							$chair = getChair();
							$records["IRB"]["email"] = '"'.$chair["email"].'"';
							$records["IRB"]["name"] = '"'.$chair["name"].'"';
							$records["IRB"]["role"] = '"IRB"';
						}
						updateUserApps($mysqli,$studyNumber,$records); // updates the 'userapps' database
						$currentStatus = getStatus($mysqli,array($studyNumber));
						if(empty($currentStatus)) {
							setStatus($mysqli,$studyNumber,"First Draft",$user);
						}
					}
			}
			return $studyNumber;
		}
	}

	function duplicateApp($mysqli,$studyNumber,$user) {
		$oldTable = 'year'.substr($studyNumber,0,4);
		$newTable = 'year'.date("Y");
		$query = 'CREATE TEMPORARY TABLE tmp SELECT * FROM '.$oldTable.' WHERE studyNumber = '.$studyNumber.';';
		if(!mysqli_query($mysqli,$query)) {
			echo '<p>Error: '.mysqli_error($mysqli).'</p>';
		}
		$query = 'ALTER TABLE tmp DROP studyNumber;';
		if(!mysqli_query($mysqli,$query)) {
			echo '<p>Error: '.mysqli_error($mysqli).'</p>';
		}
		$query = 'INSERT INTO '.$newTable.' SELECT 0,tmp.* FROM tmp;';
		if(!mysqli_query($mysqli,$query)) {
			echo '<p>Error: '.mysqli_error($mysqli).'</p>';
		} else {
			$newStudyNumber = mysqli_insert_id($mysqli); // getting study number
			$records = getStudyRoles($mysqli,$studyNumber);

			/// *** JUST FOR TESTING ***
			// print_r($records);

			updateUserApps($mysqli,$newStudyNumber,$records); // problem is here
			setStatus($mysqli,$newStudyNumber,"First Draft",$user,"Study info duplicated from ".$studyNumber);
		}
		$query = 'DROP TABLE tmp;';
		if(!mysqli_query($mysqli,$query)) {
			echo '<p>Error: '.mysqli_error($mysqli).'</p>';
		}
		return $newStudyNumber;
	}

	function confirmationEmail($to,$studyNumber,$title,$role,$newStatus,$nextStep,$remember=TRUE) {
		$subject = 'Study '.$_SESSION["studyNumber"].' '.$newStatus;
		$reminder = "";
		if($remember) $reminder = 'Remember not to begin data collection until you have received approval from the IRB. ';
		$WM = getWM();
		$chair = getChair();
		$message = '<p>This is a confirmation email letting you know about a change in the status of a human subjects application submitted to the Hanover College Institutional Review Board (IRB).</p><p> Study number '.$studyNumber.', titled <strong>'.$title.'</strong>, listed you as </p><p><strong>'.$role.'</strong></p><p>and the change in status is that the application has now been </p><p><strong>'.$newStatus.'</strong></p><p>If you believe this is an error, please contact the webmaster for the IRB, '.$WM["name"].', at '.$WM["email"].'. '.$nextStep.' To review the content of the application and check on its status, you may log in at <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a>. '.$reminder.'If you have any questions, please contact the chair of the Hanover IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
		if(mailMessage($to,$subject,$message)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function setStatus($mysqli,$studyNumber,$statusLabel,$email,$comments=NULL) {
		if(isLoggedIn()) {
			$acceptedStatus = array("First Draft","Submitted to Co-authors","Co-author Approval","Co-author Revision","Submitted to Faculty Sponsor","Faculty Sponsor Revision","Faculty Sponsor Approval","Submitted to IRB","IRB Revision","IRB Approval","Withdrawn");
			$statusLabel = mysqli_escape_string($mysqli,$statusLabel);
			if(in_array($statusLabel, $acceptedStatus)) {
				$studyNumber = mysqli_escape_string($mysqli,$studyNumber);
				$email = mysqli_escape_string($mysqli,$email);
				$comments = mysqli_escape_string($mysqli,$comments);
				$time = time();
				$query = 'INSERT INTO status (studyNumber, status, email, time, comments) VALUES ('.$studyNumber.',"'.$statusLabel.'","'.$email.'",'.$time.', "'.$comments.'")';
				if(!$mysqli->query($query)) {
					$WM = getWM();
					echo '<p>There was a problem updating the status of study '.$studyNumber.' to '.$statusLabel.'. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this message.</p>';
					echo '<p>Query: '.$query.'</p>';
					echo '<p>Error: '.$mysqli->error.'</p>';
					return FALSE;
				} else {
					setCurrentStatus($mysqli,$studyNumber,$email,$time);
					return TRUE;
				}
			}
		}
	}

	function setCurrentStatus($mysqli,$studyNumber,$email,$time) {
		// writes to the "current" table, which has _unique_ studyNumber fields (one row per studyNumber)
		// called from setStatus
		$statusLabel = computeCurrentStatus($mysqli,$studyNumber);
		$query = 'INSERT INTO current (studyNumber, status, email, time) VALUES ('.$studyNumber.',"'.$statusLabel.'","'.$email.'",'.$time.') ON DUPLICATE KEY UPDATE studyNumber='.$studyNumber.', status="'.$statusLabel.'", email="'.$email.'", time='.$time;
		if(!$mysqli->query($query)) {
			$WM = getWM();
			echo '<p>There was a problem updating the &ldquo;current&rdquo; database table for study '.$studyNumber.' to '.$statusLabel.'. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this message.</p>';
			echo '<p>Query: '.$query.'</p>';
			echo '<p>Error: '.$mysqli->error.'</p>';
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function getCurrentStatus($mysqli,$studyNumbers) {
		// studyNumbers is an array of study numbers
		// returns array with one studyNumber per row:
		// (studyNumber => 2015002, status => "Submitted to IRB", email => "altermattw@hanover.edu", time => 1231772362),(studyNumber => etc.)
		$studyImplode = implode(", ",$studyNumbers);
		$query = 'SELECT * FROM current WHERE studyNumber IN ('.$studyImplode.')';
		if ($result = $mysqli->query($query)) {
			return resultToArray($result); // gathers up all the rows, not just one
		} else {
			echo '<p>Query: '.$query.'</p>';
			echo '<p>Error: '.$mysqli->error.'</p>';
		}
	}

	function listApps($mysqli,$statusArray,$heading,$formatting="primary") {
		// $statusArray is what you would get back from getStatusApps()
		if(count($statusArray) > 0) {
			//$titles = getTitles($mysqli,array_map(function($arr) { return $arr['studyNumber']; }, $statusArray));
			$output = "";
			$class = preg_replace('/\s+/', '', $heading);
			$output.='<div class="col-md-4"> <div class="panel panel-default"> <div class="panel-heading"> <h4>'.$heading.' <span class="badge">'.count($statusArray).'</span></h4> </div> <div class="panel-body"> <div class="col-md-12">';
			foreach($statusArray as $study) {
				$output.= '<a class="btn btn-'.$formatting.' btn-block '.$class.'" role="button" href="application.php?studyNumber='.$study["studyNumber"].'">'.$study["studyNumber"].', '.date("m/d/y",$study["time"]).'</a>';
			}
			$output.='</div></div></div></div>';
			echo $output;
		}
	}

	function getStatusApps($mysqli,$status) {
		// $status is one of the status values for setStatus:  "First Draft","Submitted to Co-authors","Co-author Approval","Co-author Revision","Submitted to Faculty Sponsor","Faculty Sponsor Approval","Faculty Sponsor Revision","Submitted to IRB","IRB Revision","IRB Approval","Withdrawn"
		// gets an array of arrays, where each array contains studyNumber, status, email, and time from the "status" table
		// selects only those studies whose most recent status change is to "submitted to IRB"
		if(isLoggedIn() || isAdmin()) {
			$query = 'SELECT * FROM current WHERE status="'.$status.'"';
			if ($result = $mysqli->query($query)) {
				$data = resultToArray($result); // gathers up all the rows, not just one
				$times = array();
				foreach($data as $key => $row) {
					$times[$key] = $row['time'];
				}
				array_multisort($times, SORT_ASC, $data); // oldest on top
				return $data;
			} else {
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
			}
		}
	}

	function getStatus($mysqli,$studyNumbers,$recent=FALSE) {
		// $studyNumbers is an ARRAY of study numbers
		// returns array of array(studyNumber=>2015002,status=>"First Draft",email=>"altermattw@hanover.edu",time=>1441673156,comments=>"blah blah")
		if(isLoggedIn()) {
			$studyImplode = implode(", ",$studyNumbers);
			$query = 'SELECT * FROM status WHERE studyNumber IN ('.$studyImplode.')';
			if ($result = $mysqli->query($query)) {
				$data = resultToArray($result); // gathers up all the rows, not just one
				$statusLabels = array();
				$times = array();
				foreach($data as $key => $row) {
					$statusLabels[$key] = $row['status'];
					$times[$key] = $row['time'];
				}
				array_multisort($times, SORT_DESC, $statusLabels, SORT_DESC, $data); // most recent on top
				if($recent) {
					return(arrayUniqueFromKey($data,'studyNumber'));
				} else {
					return $data;
				}
			} else {
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
			}
		}
	}

	function getRoleEmails($mysqli,$studyNumber,$role) {
		// $studyNumber is just one study number
		// $role is "author","sponsor", or "IRB"
		// returns an array of emails that have a given role for a given study
		if(isLoggedIn()) {
			$query = 'SELECT * FROM userapps WHERE studyNumber='.$studyNumber.' AND role="'.$role.'"';
			if ($result = $mysqli->query($query)) {
				$rows = resultToArray($result); // gathers up all the rows, not just one
				$emails = array();
				foreach($rows as $row) {
					$emails[] = $row['email'];
				}
				return $emails;
			} else {
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
			}
		}
	}

	function getStudyRoles($mysqli,$studyNumber) {
		if(isLoggedIn()) {
			$query = 'SELECT * FROM userapps WHERE studyNumber='.$studyNumber;
			if ($result = $mysqli->query($query)) {
				$rows = resultToArray($result); // gathers up all the rows, not just one
				$records = array();
				$i = 1;
				foreach($rows as $person) {
					if($person["role"]=="author") {
						$records[$i]["email"]='"'.$person["email"].'"';
						$records[$i]["name"]='"'.$person["name"].'"';
						$records[$i]["role"]='"author"';
						$i++;
					} else {
						if($person["role"]=="sponsor") {
							$records["sponsor"]["email"]='"'.$person["email"].'"';
							$records["sponsor"]["name"]='"'.$person["name"].'"';
							$records["sponsor"]["role"]='"sponsor"';
						} else {
							if($person["role"]=="IRB") {
								$records['"IRB"']["name"]='"'.$person["name"].'"';
								$records['"IRB"']["email"]='"'.$person["email"].'"';
								$records['"IRB"']["role"]='"IRB"';
							}
						}
					}
				}
				return $records;
			} else {
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
			}
		}
	}

	function updateUserApps($mysqli,$studyNumber,$records) {
		// This assumes that the $records coming in are a complete list of all the authors and the faculty sponsor.
		// It will delete any authors and faculty sponsors currently attached to that study number
		// and replace them with what is in $records.
		// $records is an array of arrays, with format [1=>[email,role,name],2=>[email,role,name],"sponsor"=>[email,role,name]]

		// delete old authors and sponsors for that study

		// TODO:  any way to do this with an INSERT OR UPDATE command?
		// TODO:  add update to IRB reviewer, but only if user isAdmin()

		if(isLoggedIn()) { // executes only if user is logged in
			$query = 'DELETE FROM userapps WHERE studyNumber="'.$studyNumber.'" AND (role="author" OR role="sponsor");';
			// if(isAdmin()) $query = 'DELETE FROM userapps WHERE studyNumber="'.$studyNumber.'";';
			$WM = getWM();
			if(!$mysqli->query($query)) {
				echo '<p>There was a problem deleting old names and emails for this study from the userapps database. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this message.</p>';
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
			}
			// insert new userapps authors and sponsor for studyNumber
			foreach($records as $record) {
				$record["studyNumber"] = $studyNumber;
				$query = 'INSERT INTO userapps ('.implode(", ",array_keys($record)).') VALUES ('.implode(", ",$record).');';
				if(!$mysqli->query($query)) {
				echo '<p>There was a problem adding new names and emails for this study to the userapps database. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this message.</p>';
				echo '<p>Query: '.$query.'</p>';
				echo '<p>Error: '.$mysqli->error.'</p>';
				}
			}
		}
	}

	function updateLastLogin($email,$mysqli) {
		$email = mysqli_escape_string($mysqli,$email);
		$query = 'UPDATE user SET lastLogin='.time().' WHERE email='.$email;
		if($mysqli->query($query)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function badLogin($email,$mysqli) { // runs when user enters login incorrectly
		$email = mysqli_escape_string($mysqli,$email);
		// 5 badLogin fields in DB holding integers representing time (Unix epoch)
			// arranged badLogin1 ... badLogin5 in order from most recent to oldest
		// read 5 badLogin fields as an array
		// count how many are not NULL
			// if less than 5, move the others down one position and add the current time to badLogin1
			// if 5 already, check the time for the smallest (oldest) one
				// if it is less than 24 hours since the current time, give alert and prompt to change password
				// if it is more than 24 hours since the current time, delete oldest value, move the others down one position, and enter the current time as badLogin1
	}

	function adminGetRecords($table,$fields,$where,$mysqli) {
		// $table is the word "year", a 4-digit year, and the lower-case letter A or B:  year2015a
			// the 'A' table holds info without revisions
			// the 'B' table can hold revision info
				// (but will not in early implementations)
		// $fields is an array of variables to get data for
		// $where is an associative array stating the keys and values for matching (e.g., for a particular email, for a particular study number, etc.)
		// $mysqli is the returned result from the myConnect() function, above
	}

	function getRecords($mysqli,$tableName) {
		// Retrieve records.  $mysqli is the name of the connection, $tableName is the name of the table.
		// Usage:  $data = getRecords($mysqli,"FleckTurjman");
		$val = mysqli_query($mysqli, 'select 1 from '.$tableName);
		if($val == FALSE)
		{
			// TABLE DOES NOT EXIST.
			echo '<p>Table '.$tableName.' does not exist.</p>'.PHP_EOL;
		} else {
			// TABLE DOES EXIST. RETURN DATA.
				// TODO: *** MAKE THIS MORE SELECTIVE!! (just some records, not all) ***
			$sql = 'SELECT * FROM '.$tableName;
			$result=mysqli_query($mysqli,$sql);
			return $result;
		}
	}




// end MySQL utilities

function arrayUniqueFromKey(array $arr,$key)
{
    $titles = array();$ret = array();
    foreach ($arr as $v) {
        if (!in_array($v[$key],$titles)) {
            $titles[] = $v[$key];
            $ret[] = $v;
        }
    }
    return $ret;
}

function encryptPassword($password) {
		$random = openssl_random_pseudo_bytes(18);
		$salt = sprintf('$2y$%02d$%s',
		    13, // 2^n cost factor
		    substr(strtr(base64_encode($random), '+', '.'), 0, 22)
		);
		return crypt($password, $salt); // encrypting password
}

function makeHash() {
	return md5( rand(0,1000) );
}

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

function checkPassword($given_password,$db_hash) {
	// givenPassword is what you get from the user
	// db_hash is the encrypted version of the password, stored in the db
	$given_hash = crypt($given_password, $db_hash);
	if (isEqual($given_hash, $db_hash)) {
		return true;
	} else {
		return false;
	}
}

function validateUser($userid) // called if the login is successful
{
    session_regenerate_id (); //this is a security measure
    $_SESSION['valid'] = 1;
    $_SESSION['userid'] = $userid;
    $record = getUserRecord($userid,myConnect());
    $_SESSION['name'] = $record['firstName'].' '.$record['lastName'];
    $administrators = array(
			"jacks@hanover.edu",
			"bruyninckx@hanover.edu",
			"vosm@hanover.edu",
			"altermattw@hanover.edu",
			"ryle@hanover.edu"
			);
		if(in_array($userid,$administrators)) { // does user have admin privileges?
			$_SESSION['admin'] = 1;
		}
}

function isLoggedIn()
{
    if(isset($_SESSION['valid']) && $_SESSION['valid'] === 1) {
    	  return TRUE;
    	} else {
		    return FALSE;
    	}

}

function checkLogin() {
	if(!isLoggedIn()) {
		echo '<p>You need to be logged in to view this page. Please <a href="login.php">Click Here</a> to go to the login page.</p>';
		logout();
		die();
	}
}

function isAdmin()
{
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {
    	  return true;
    	} else {
		    return false;
    	}

   // return true;    // for testing only:
}

function logout()
{
   $_SESSION = array(); //destroy all of the session variables
}

// file upload utilities
	// $ext = pathinfo($uploadedFilename)['extension'];
	// while (true) { // generate unique filename for uploads
 // 		$prefix = date('Y',time()) . '.'; // prepends the filename with the 4-digit year and a period
 // 		$filename = uniqid($prefix, true) . '.' . $ext;
 // 		if (!file_exists('../upload/' . $filename)) break;
	// }

?>
