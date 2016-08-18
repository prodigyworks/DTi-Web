<?php
	//Include database connection details
	require_once('system-db.php');
	require_once('sqlfunctions.php');
	
	start_db();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	if (isset($_FILES['imageid'])) {
		$imageid = getImageData("imageid");
		
	} else {
		$imageid = "imageid";
	}
	
	//Sanitize the POST values
	$fname = clean($_POST['fname']);
	$lname = clean($_POST['lname']);
	$password = clean($_POST['password']);
	$cpassword = clean($_POST['cpassword']);
	$email = clean($_POST['email1']);
	$cemail = clean($_POST['confirmemail']);
	$mobile = clean($_POST['mobile1']);
	
	//Input Validations
	if($fname == '') {
		$errmsg_arr[] = 'First name missing';
		$errflag = true;
	}
	if($lname == '') {
		$errmsg_arr[] = 'Last name missing';
		$errflag = true;
	}
	
	if (! isset($_GET['id'])) {
		$login = clean($_POST['login']);
		if($login == '') {
			$errmsg_arr[] = 'Login ID missing';
			$errflag = true;
		}
	}
	
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	if($cpassword == '') {
		$errmsg_arr[] = 'Confirm password missing';
		$errflag = true;
	}
	
	if( strcmp($password, $cpassword) != 0 ) {
		$errmsg_arr[] = 'Passwords do not match';
		$errflag = true;
	}
	
	if( strcmp($email, $cemail) != 0 ) {
		$errmsg_arr[] = 'Email addresses do not match';
		$errflag = true;
	}
	
	$matches = null;
		
	$memberid = 0;
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: " . $_SERVER['HTTP_REFERER']);
		exit();
	}
	
	$uepasswd = mysql_escape_string($password);
	$pwd = md5($password);
	$loggedon = getLoggedOnMemberID();
	
	if (! isset($_GET['id'])) {
		//Check for duplicate login ID
		if($login != '') {
			$qry = "SELECT * FROM {$_SESSION['DB_PREFIX']}members WHERE login='$login'";
			$result = mysql_query($qry);
			if($result) {
				if(mysql_num_rows($result) > 0) {
					$errmsg_arr[] = 'Login ID already in use';
					$errflag = true;
				}
				@mysql_free_result($result);
			}
		}
		
		$fullname = $fname . " " . $lname;
		
		//Create INSERT query
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}members 
				(
					firstname, lastname, fullname, 
					login, uepasswd, passwd, mobile1,
					email1, status, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES
				(
					'$fname','$lname', '$fullname', 
					'$login', '$uepasswd', '$pwd', '$mobile',
					'$email', 'Y', 'Y', 
					NOW(), $loggedon, 
					NOW(), $loggedon
				)";
		$result = @mysql_query($qry);
		$memberid = mysql_insert_id();
		
		if (! $result) {
			logError("$qry - " . mysql_error());
		}
	
		//Create INSERT query
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles
				(
					memberid, roleid, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES
				(
					$memberid, 'PUBLIC', 
					NOW(), $loggedon, 
					NOW(), $loggedon
				)";
		$result = @mysql_query($qry);
		
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles
				(
					memberid, roleid, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES
				(
					$memberid, 'USER', 
					NOW(), $loggedon, 
					NOW(), $loggedon
				)";
		$result = @mysql_query($qry);
		
		if (isset($_POST['accounttype'])) {
			$accountrole = $_POST['accounttype'];

			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles
					(
						memberid, roleid, 
						metacreateddate, metacreateduserid, 
						metamodifieddate, metamodifieduserid
					) 
					VALUES
					(
						$memberid, '$accountrole', 
						NOW(), $loggedon, 
						NOW(), $loggedon
					)";
			$result = @mysql_query($qry);
		}
		
		sendRoleMessage("ADMIN", "User Registration", "User " . $login . " has been registered as a user.<br>Password : " . $_POST['password']);
		sendUserMessage($memberid, "User Registration", "<h3>Welcome $fname $lname.</h3><br>You have been registered as a user '{$_SESSION['EMAIL_NAME']}.<br>Please click on the <a href='" . getSiteConfigData()->domainurl . "/index.php'>link</a> to activate your account.<br><br><h4>Login details</h4>User ID : $login<br>Password : " . $_POST['password']);
		
		if($result) {
			header("location: system-register-success.php");
	
		} else {
			logError("1 Query failed:" . mysql_error());
		}
		
	} else {
		$memberid = $_GET['id'];
		
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET 
				email1 = '$email', 
				imageid = $imageid,
				firstname = '$fname', 
				uepasswd = '$uepasswd',
				lastname = '$lname', 
				mobile1 = '$mobile',
				fullname = '$fname $lname',
				lastaccessdate = NOW(),
				passwd = '$pwd', 
				metamodifieddate = NOW(), 
				metamodifieduserid = $loggedon
				WHERE member_id = $memberid";
		$result = mysql_query($qry);
		
		logError($qry, false);

		if (! $result) {
			logError("UPDATE members failed:" . mysql_error());
		}
		
		if (isset($_FILES['imageid'])) {
			$_SESSION['SESS_FIRST_IMAGE'] = $imageid;
		}
		
		$_SESSION['SESS_FIRST_NAME'] = $fname;
		$_SESSION['SESS_LAST_NAME'] = $lname;
		
		sendRoleMessage("ADMIN", "User Amendment", "<h3>User amendment.</h3><br>Your details have been amended by the System Administration.<br>Your password has been changed to: <i>$password</i>.");
		sendUserMessage($memberid, "User Amendment", "<h3>User amendment.</h3><br>Your details have been amended by the System Administration.<br>Your password has been changed to: <i>$password</i>.");
		
		header("location: system-register-amend.php");
	}
	
	//Check whether the query was successful or not
?>