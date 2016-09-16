<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	print_r(getStudyRoles($mysqli,2015014));
	duplicateApp($mysqli,2015014,'altermattw@hanover.edu');
?>