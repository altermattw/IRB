<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	if(hasAccess($mysqli,'jacks@hanover.edu',2015013)) {
		echo 'yes';
	}	else {
		echo 'no';
	}
?>