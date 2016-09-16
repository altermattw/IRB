<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$allStatus = computeCurrentStatus($mysqli,2015016);
	// if(setCurrentStatus($mysqli,2015016,"altermattw@hanover.edu",time())) {
	// 	echo 'it worked';
	// } else {
	// 	echo 'nope';
	// }
	print_r($allStatus);	
?>