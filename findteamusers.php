<?php
	require_once('system-db.php');
	
	start_db();
	
	$json = array();
	
	$teamid = $_GET['id'];
	$qry = "SELECT DISTINCT A.memberid, B.fullname, A.teamid 
			FROM {$_SESSION['DB_PREFIX']}teamuser A 
			INNER JOIN {$_SESSION['DB_PREFIX']}team D 
			ON D.id = A.teamid 
			INNER JOIN {$_SESSION['DB_PREFIX']}members B 
			ON B.member_id = A.memberid 
			WHERE D.id = $teamid
			ORDER BY B.fullname";
	
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$line = array(
					"id" => $member['memberid'], 
					"name" => $member['fullname'],
					"teamid" => $member['teamid']
				);  
			
			array_push($json, $line);
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	echo json_encode($json); 
?>