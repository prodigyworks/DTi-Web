<?php
	require_once('system-db.php');
	
	start_db();
	
	$usercertificateid = $_GET['id'];
	$memberid = getLoggedOnMemberID();
	$sessionid = session_id();
	
	$qry = "SELECT A.id FROM {$_SESSION['DB_PREFIX']}documents A 
		    WHERE A.sessionid = '$sessionid' 
		    AND A.id NOT IN (
		    	SELECT documentid 
		    	FROM {$_SESSION['DB_PREFIX']}usercertificatedocs 
		    	WHERE documentid = A.id
		    ) 
		    ORDER BY A.id";
	$result = mysql_query($qry);
	
	if (! $result) {
		logError($qry . " = " . mysql_error());
	}
	
	while (($member = mysql_fetch_assoc($result))) {
		$documentid = $member['id'];
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}usercertificatedocs 
				(
					usercertificateid, documentid, createddate, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES 
				(
					$usercertificateid, $documentid, NOW(), 
					NOW(), $memberid, 
					NOW(), $memberid
				)";
				
		$itemresult = mysql_query($qry);
		
		if (! $itemresult) {
			logError($qry . " = " . mysql_error());
		}
	}
	
	$qry = "UPDATE {$_SESSION['DB_PREFIX']}documents  SET 
			sessionid = NULL, 
			metamodifieddate = NOW(), 
			metamodifieduserid = $memberid
		    WHERE sessionid = '$sessionid'";
	$result = mysql_query($qry);
	
	if (! $result) {
		logError($qry . " = " . mysql_error());
	}
		
	if (isset($_GET['refer'])) {
	  	header("location: " . base64_decode($_GET['refer']));
		
	} else {
	  	header("location: " . $_SERVER['HTTP_REFERER']);
	}	
?>