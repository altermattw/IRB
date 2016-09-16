<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$studyNumbers = getStudies($mysqli,"altermattw@hanover.edu");
	$appList = array();
	$roles = array("author","sponsor","IRB");
	foreach($studyNumbers as $study) {
		foreach($roles as $role) {
			if(isset($study[$role])) {
				if(in_array($_SESSION["userid"], array_keys($study[$role]))) { // user is author of this study
					// $appList[$role][$study["status"]][] = $study;
					echo '<p>'.$role.':</p>';
					echo '<p>&gt;'.$study["status"].'</p>';
					echo '<p>&gt;&gt;';
					print_r($study);
					echo '<br>';
				}	
			}
			
		}		
	}
	// To Display:
		// First, all the ones you are an author on.
		// Second, if you are sponsor on any, 
			// Sort by Course and Number.
			// Sort by Status:  
				// 'Submitted to Faculty Sponsor' at the top, in red.	
				// Apps with oldest update (from 'current' DB) at the top
				// 'Approved by IRB' at the bottom, in green.		
			


	print_r($appList);
?>