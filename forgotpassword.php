<?php
	require_once("system-db.php");
	
	start_db();
	
	$errmsg_arr = null;
	
	if (! isset($_POST['login']) || $_POST['login'] == "") {
		$errmsg_arr[] = "Missing User ID";
		
	} else {
		$word = "";
		$memberid = 0;
		$login = $_POST['login'];
		
		$_SESSION['ERR_USER'] = $_POST['login'];
		
		$qry = "SELECT * 
				FROM {$_SESSION['DB_PREFIX']}members 
				WHERE login = '$login'";
		$result = mysql_query($qry);
		
		if($result) {
			if(mysql_num_rows($result) == 1) {
				$member = mysql_fetch_assoc($result);
				$memberid = $member['member_id'];
			   	$password = $member['uepasswd'];
				$errmsg_arr[] = "An email has been sent with a reset password.";
				
				sendUserMessage(
						$memberid, 
						"Forgotten password", 
						"Your password is <i>$password</i>.<br>Please contact your system administrator if you have any problems."
					);
				
			} else {
				$errmsg_arr[] = "Invalid user.";
			}
			
		} else {
			$errmsg_arr[] = "Invalid user.";
		}
	}
	
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	
	header("location: passwordchanged.php");
?>