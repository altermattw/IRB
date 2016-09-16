<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$studies = getStatusApps($mysqli);
	echo '<p>Studies waiting for approval: </p>';
	foreach($studies as $study) {
		echo '<p>Studynumber: '.$study["studyNumber"].', time: '.$study["time"].'</p>';
	}
?>