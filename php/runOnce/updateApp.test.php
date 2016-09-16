<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 1;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	echo '<p>Testing updateApp function</p>';
	$user = "altermattw@hanover.edu";
	$tableName = "year2015";
	$data = ['5Author1D' => 'alfons@hb.edu','5Author1A' => 'Alfie Sandretti','sponsorEmail' => 'carl@gh.bu','sponsorName' => 'Carl Sacks', '5Author2A' => 'Tony Spinelli', '5Author2D' => 'spinell@berseid.de', 'title' => 'One Crazy Study', 'studyNumber' => '2015003'];
	updateApp($mysqli,$user,$tableName,$data);	
?>