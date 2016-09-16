<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	$_SESSION['userid'] = 'altermattw@hanover.edu';
	echo '<p>userid: '.$_SESSION['userid'].'</p>';
	if(!isset($mysqli)) $mysqli = myConnect();													
	$approved = getApprovalStatus($mysqli,"2016009");
	print_r($approved);
	echo '<p>array_keys($approved["authors"])</p>';
	echo array_keys($approved["authors"])[2];
	if(array_keys($approved["authors"])[2]=='richardsonj16@hanover.edu ') {
		echo 'true';
	} else {
		echo 'false';
	}
	echo '<p>&nbsp;</p>';
	function isAuthor($authorName,$approved) {
				if(in_array($authorName,array_keys($approved["authors"]))) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
	if(isAuthor($_SESSION["userid"],$approved)) {
		echo '<p>Is an author.</p>';
	} else {
		echo '<p>Is NOT an author.</p>';
	}
?>