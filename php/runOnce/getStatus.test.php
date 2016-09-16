<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	print_r(getStatus($mysqli,array("2016009")));	
?>