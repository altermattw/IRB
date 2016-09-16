<?php
	require('../SQLutils.php');	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$email = "altermattw@hanover.edu";
	$hash = "e6b4b2a746ed40e1af829d1fa82daa10";
	echo mailVerification($email,$hash);		
?>