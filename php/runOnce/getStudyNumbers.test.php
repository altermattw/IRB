<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 0;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$studyNumbers = getStudyNumbers($mysqli,"altermattw@hanover.edu","sponsor");
	echo '<p>studyNumbers: </p>';
	foreach($studyNumbers as $study) {
		echo '<p>'.$study.'</p>';
	}
?>