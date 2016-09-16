<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	$studyNumbers = array(2015001,2015007,2016001);
	$titles = getTitles($mysqli,$studyNumbers);
	echo '<p>Titles: </p>';
	foreach($titles as $title) {
		echo '<p>Studynumber: '.$title["studyNumber"].', Title: '.$title["title"].'</p>';
	}
?>