<?php

function updateUserApps($mysqli,$studyNumber,$authors,$sponsor) {
		// $authors is an array of author emails
		// $sponsor is the email of the faculty sponsor
		$feedback = "";
		$newAuthors = $authors; // list of newly added authors
		$remove = array();
		// First, check the overlap between the incoming info and the database records
		$query = 'SELECT * FROM userapps WHERE studyNumber="'.$studyNumber.'";';	
		if ($result = $mysqli->query($query)) {
			$rows = resultToArray($result); // all the rows with that studyNumber
			foreach($rows as $row) {
				if(in_array($row["email"],$authors)) { // DB entry *is* found among incoming authors
					unset($newAuthors[array_search($row["email"],$newAuthors)]); // remove from list of new authors
				} else { // DB entry not found among authors
					if($row["role"] == "author") { // DB entry is indeed an author; add to delete list
						$remove[] = [$row["email"],"author",$studyNumber];
					} else { // DB entry is not an author, may be sponsor or IRB
						if(($row["role"] == "sponsor") && ($row["email"] != $sponsor)) { // sponsor has changed							// add old sponsor to remove list
							$remove[] = [$row["email"],"sponsor",$studyNumber];

						}
					}
				}			
			}
			
			removeUserAppsRecords($mysqli,$studyNumber,$)
		} 		
	}


// any emails in $authorEmails that are not in $DBemails?  
							$added = array_diff($authorEmails,$DBemails);
							if(count($added) > 0) { // Yes:  people have been added
								foreach($added as $addedEmail) {
								// add those people to 'userapps' table
									$role = "author";
									if($addedEmail == $app["sponsorEmail"]) $role = "sponsor";
									$query = 'INSERT INTO userapps (email,role,studyNumber) VALUES ("'.$addedEmail.'", "'.$role.'", "'.$studyNumber.'");';
									$mysqli->query($query);
									if($mysqli_affected_rows($mysqli) > 0) { // if the insert was successful
									// email added individuals		
										$subject='Removed from IRB application';
										$msg='<p>You have been added to Institutional Review Board study number '.$studyNumber.' by '.$user.'. If you believe this is an error, please contact '.$user.' and ask them to remove you from the study. You may also contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].', if you have any questions.</p>';
										mailMessage($cutEmail,$subject,$msg);
									} else {
										echo '<p><strong>There was a problem with adding '.$addEmail.' to the application.</strong> Please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' and explain what happened. Sorry for the inconvenience.</p>';				
									}
								}
							}

	function removeAuthorSponsor($mysqli,$studyNumber,$email,$role) {
		$query = 'DELETE FROM userapps WHERE email="'.$email.'" AND studyNumber="'.$studyNumber.'" AND role="'.$role.'";';
		$mysqli->query($query);
		if($mysqli_affected_rows($mysqli) > 0) { // if the delete was successful

		}
	}
		
					
						$apps = resultToArray($result); // an associative array with keys 'email', 'role', and 'studyNumber'
						foreach ($apps as $app) {

						}
						$DBemails = explode(",",$app['authorEmails']);
						// any emails in $DBemails that are not in $authorEmails?  
							$cut = array_diff($DBemails,$authorEmails);
							if(count($cut) > 0) {  // Yes: authors have been cut
								foreach($cut as $cutEmail) {
									// remove those people from 'userapps' table
									$query = 'DELETE FROM userapps WHERE email="'.$cutEmail.'" AND studyNumber="'.$studyNumber.'"';
									$mysqli->query($query);
									if($mysqli_affected_rows($mysqli) > 0) { // if the delete was successful
										// email cut individuals
										$subject='Removed from IRB application';
										$msg='<p>You have been removed from Institutional Review Board study number '.$studyNumber.' by '.$user.'. If you believe this is an error, please contact '.$user.' and ask them to add you back to the study. You may also contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].', if you have any questions.</p>';
										mailMessage($cutEmail,$subject,$msg);
									} else {
										echo '<p><strong>There was a problem with removing '.$cutEmail.' from the application.</strong> Please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' and explain what happened. Sorry for the inconvenience.</p>';
									}										
								}								
							}
		return $feedback;
	}

?>