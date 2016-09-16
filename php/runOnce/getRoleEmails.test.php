<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	print_r(getRoleEmails($mysqli,"2015023","sponsor"));	
?>