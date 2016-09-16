<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	setStatus($mysqli,'2015017','Submitted to Faculty Sponsor','altermattw@hanover.edu');	
	
?>