<?php
	require_once('system-db.php');
	require_once('sqlfunctions.php');
	
	start_db();

	$imageid = getFileData("imageid");
	header("location: $callback?imageid=$imageid");	
?>