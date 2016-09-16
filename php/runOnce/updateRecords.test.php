<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 0;
	$mysql = myConnect();
	$data = array("title" => "The REAL study 2","authorNames" => "Bill Altermatt");
	updateRecords($mysql,'year2015',$data);
	echo '<p>studyNumber: '.mysqli_insert_id($mysql).'</p>';
?>