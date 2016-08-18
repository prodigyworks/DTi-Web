<?php
	require_once('system-db.php');
	
	start_db();
	
	createComboOptions("id", "name", "{$_SESSION['DB_PREFIX']}certificate", "WHERE categoryid = {$_POST['categoryid']}");
?>