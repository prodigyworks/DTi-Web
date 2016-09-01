<?php
	require_once('system-db.php');
	require_once('sqlfunctions.php');
	
	start_db();
	
	unset($_SESSION['ERRMSG_ARR']);
	
	try {
	    $imageid = getFileData("document", session_id());
	    
	} catch (Exception $e) {
		$_SESSION['ERRMSG_ARR'] = $e->getMessage();
	  	header("location: " . $_SERVER['HTTP_REFERER']);
	}
    
    if (isset($_GET['documentcallback'])) {
	  	header("location: " . $_GET['documentcallback'] . "?id=" . $_GET['identifier'] . "&refer=" . base64_encode($_SERVER['HTTP_REFERER']));
	  	
    } else {
	  	header("location: " . $_SERVER['HTTP_REFERER']);
    }
 ?>