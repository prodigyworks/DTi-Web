<?php
	
class SiteConfigClass {
	public $domainurl;
	public $emailfooter;
	public $lastschedulerun;
	public $runscheduledays;
	public $address;
}

function start_db() {
	if(! isset($_SESSION)) {
		session_start();
	}
	
	date_default_timezone_set('Europe/London');	
	error_reporting(0);

	if (! isset($_SESSION['PRODIGYWORKS.INI'])) {
		$_SESSION['PRODIGYWORKS.INI'] = parse_ini_file("prodigyworks.ini");
		$_SESSION['DB_PREFIX'] = $_SESSION['PRODIGYWORKS.INI']['DB_PREFIX']; 
		$_SESSION['CACHING'] = $_SESSION['PRODIGYWORKS.INI']['CACHING']; 
		$_SESSION['EMAIL_ADDRESS'] = $_SESSION['PRODIGYWORKS.INI']['EMAIL_ADDRESS']; 
		$_SESSION['EMAIL_NAME'] = $_SESSION['PRODIGYWORKS.INI']['EMAIL_NAME']; 
	}
	
	if (! defined('DB_HOST')) {
		$iniFile = $_SESSION['PRODIGYWORKS.INI'];
		
		define('DB_HOST', $iniFile['DB_HOST']);
	    define('DB_USER', $iniFile['DB_USER']);
	    define('DB_PASSWORD', $iniFile['DB_PASSWORD']);
	    define('DB_DATABASE', $iniFile['DB_DATABASE']);
	    define('DEV_ENV', $iniFile['DEV_ENV']);
	    
		//Connect to mysql server
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		
		if (!$link) {
			logError('Failed to connect to server: ' . mysql_error());
		}
		
		//Select database
		$db = mysql_select_db(DB_DATABASE);
		
		if(!$db) {
			logError("Unable to select database:" . DB_DATABASE);
		}
		
		mysql_query("BEGIN");
	
		if (! isset($_SESSION['SITE_CONFIG'])) {
			$qry = "SELECT * FROM {$_SESSION['DB_PREFIX']}siteconfig";
			$result = mysql_query($qry);
	
			//Check whether the query was successful or not
			if ($result) {
				if (mysql_num_rows($result) == 1) {
					$member = mysql_fetch_assoc($result);
					
					$data = new SiteConfigClass();
					$data->domainurl = $member['domainurl'];
					$data->emailfooter = $member['emailfooter'];
					$data->lastschedulerun = $member['lastschedulerun'];
					$data->runscheduledays = $member['runscheduledays'];
					$data->address = $member['address'];
					
					$_SESSION['SITE_CONFIG'] = $data;
				}
					
			} else {
				header("location: system-access-denied.php");
			}
		}
	    
	}
}

function getSiteConfigData() {
	return $_SESSION['SITE_CONFIG'];
}

function GetUserName($userid = "") {
	if ($userid == "") {
		return $_SESSION['SESS_FIRST_NAME'] . " " . $_SESSION['SESS_LAST_NAME'];
		
	} else {
		$qry = "SELECT * 
				FROM {$_SESSION['DB_PREFIX']}members A 
				WHERE A.member_id = $userid ";
		$result = mysql_query($qry);
		$name = "Unknown";
	
		//Check whether the query was successful or not
		if($result) {
			while (($member = mysql_fetch_assoc($result))) {
				$name = $member['firstname'] . " " . $member['lastname'];
			}
		}
		
		return $name;
	}
}
	
function endsWith( $str, $sub ) {
	return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
}

function isAuthenticated() {
	return ! (!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == ''));
}

function smtpmailer($to, $from, $from_name, $subject, $body, $attachments = array()) { 
	if (DEV_ENV == "true") {
		return;
	}
	
	require_once('phpmailer/class.phpmailer.php');

	global $error;
	
	$array = explode(',', $to);
	
	try {
		$mail = new PHPMailer();  // create a new object
		$mail->AddReplyTo($from, $from_name);
		$mail->SetFrom($_SESSION['EMAIL_ADDRESS'], $from_name);
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
        
		for ($i = 0; $i < count($attachments); $i++) {
			$mail->AddAttachment($attachments[$i]);
		}
		
		for ($i = 0; $i < count($array); $i++) {
			$mail->AddAddress($array[$i]);
		}

		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			logError($error, false);
			return false;
			
		} else {
			$error = 'Message sent!';
			return true;
		}
	
	} catch (phpmailerException $e) {
		logError($e->errorMessage() . " for $to Subject $subject", false);
			
	} catch (Exception $e) {
		logError($e->errorMessage() . " for $to Subject $subject", false);
	}
}

function sendRoleMessage($role, $subject, $message, $attachments = array()) {
	$qry = "SELECT B.email1, B.firstname, B.member_id 
			FROM {$_SESSION['DB_PREFIX']}userroles A 
			INNER JOIN {$_SESSION['DB_PREFIX']}members B 
			ON B.member_id = A.memberid 
			WHERE A.roleid = '$role' ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer(
					$member['email1'], 
					$_SESSION['EMAIL_ADDRESS'], 
					$_SESSION['EMAIL_NAME'], 
					$subject, 
					getEmailHeader() . "<h4>Dear " . $member['firstname'] . ",</h4><p>$message</p>" . getEmailFooter(), 
					$attachments
				);
			
			$subject = mysql_escape_string($subject);
			$message = mysql_escape_string($message);
			
			sendMessage($subject, $message, $member['member_id']);
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	if (!empty($error)) echo $error;
}

function sendInternalRoleMessage($role, $subject, $message, $attachments = array()) {
	$memberid = getLoggedOnMemberID();
	$from = $_SESSION['EMAIL_ADDRESS'];
	$fromName = $_SESSION['EMAIL_NAME'];
	
	$qry = "SELECT B.email1, B.firstname, B.lastname 
			FROM {$_SESSION['DB_PREFIX']}members B 
			WHERE B.member_id = $memberid";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$from = $member['email1'];
			$fromName = $member['firstname'] . " " . $member['lastname'];
		}
	}

	$qry = "SELECT B.email1, B.firstname, B.member_id 
			FROM {$_SESSION['DB_PREFIX']}userroles A 
			INNER JOIN {$_SESSION['DB_PREFIX']}members B 
			ON B.member_id = A.memberid 
			WHERE A.roleid = '$role' ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer(
					$member['email1'], 
					$from, $fromName, 
					$subject, 
					getEmailHeader() . "<h4>Dear " . $member['firstname'] . ",</h4><p>$message</p>" . getEmailFooter(), 
					$attachments
				);
			
			$subject = mysql_escape_string($subject);
			$message = mysql_escape_string($message);
			
			sendMessage($subject, $message, $member['member_id']);
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	if (!empty($error)) echo $error;
}

function sendUserMessage($id, $subject, $message, $footer = "", $attachments = array(), $action = "") {
	$qry = "SELECT B.email1, B.firstname 
			FROM {$_SESSION['DB_PREFIX']}members B 
			WHERE B.member_id = $id ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer(
					$member['email1'], 
					$_SESSION['EMAIL_ADDRESS'], 
					$_SESSION['EMAIL_NAME'], 
					$subject, 
					getEmailHeader() . "<h4>Dear " . $member['firstname'] . ",</h4><p>$message</p>" . getEmailFooter(). $footer, 
					$attachments
				);
				
			$subject = mysql_escape_string($subject);
			$message = mysql_escape_string($message);
				
			sendMessage($subject, $message, $id, $action);
		}

	} else {
		logError($qry . " - " . mysql_error());
	}

	if (!empty($error)) echo $error;
}

function isMobileUserAgent() {
	$result = mysql_query("SELECT id 
						   FROM {$_SESSION['DB_PREFIX']}useragent
						   WHERE useragent = '{$_SERVER['HTTP_USER_AGENT']}'"
		);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			return true;
		}
		
	} else {
		logError($qry  . " - " . mysql_error());
	}
	
	return false;
}

function sendMessage($subject, $message, $id, $action = "") {
	$memberid = getLoggedOnMemberID();
	$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}messages 
			(
				from_member_id, to_member_id, 
				subject, message, 
				createddate, status, action, 
				metacreateddate, metacreateduserid, 
				metamodifieddate, metamodifieduserid
			)
			VALUES 
			(
				1, $id, 
				'$subject', '$message', 
				NOW(), 'N', '$action', 
				NOW(), $memberid, 
				NOW(), $memberid
			)";
	
	if (! mysql_query($qry)) {
		logError($qry . " - " . mysql_error());
	}
}

function sendInternalUserMessage($id, $subject, $message, $footer = "", $attachments = array(), $action = "") {
	$from = $_SESSION['EMAIL_ADDRESS'];
	$fromName = $_SESSION['EMAIL_NAME'];
	$memberid = getLoggedOnMemberID();
	
	$qry = "SELECT B.email1, B.firstname, B.lastname 
			FROM {$_SESSION['DB_PREFIX']}members B 
			WHERE B.member_id = $memberid";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$from = $member['email1'];
			$fromName = $member['firstname'] . " " . $member['lastname'];
		}
	}

	$qry = "SELECT B.email1, B.firstname 
			FROM {$_SESSION['DB_PREFIX']}members B 
			WHERE B.member_id = $id ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			smtpmailer(
					$member['email1'], 
					$from, 
					$fromName, 
					$subject, 
					getEmailHeader() . "<h4>Dear " . $member['firstname'] . ",</h4><p>$message</p>" . getEmailFooter(). $footer, 
					$attachments
				);
			
			$subject = mysql_escape_string($subject);
			$message = mysql_escape_string($message);
			
			sendMessage($subject, $message, $id, $action);
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	if (!empty($error)) echo $error;
}

function createLazyCombo($id, $value, $name, $table, $where = " ", $required = true, $size = 40, $inputname = null) {
	$qry = "SELECT A.$value AS id, A.$name AS value " .
			"FROM $table A " .
			$where . " ";
?>
<input type="text" id="<?php echo $id; ?>_lazy" name="<?php echo $id; ?>_lazy" size="<?php echo $size; ?>" value="" />
<script>
	$(document).ready(
			function() {
				$("#<?php echo $id; ?>_lazy").autocomplete({
					source: "findcombodata.php?name=<?php echo base64_encode($name); ?>&sql=<?php echo base64_encode($qry); ?>",
					minLength: 1,//search after two characters
					select: function(event,ui){
							$("#<?php echo $id; ?>").val(ui.item.id).trigger("change");
					    }
					});
			}
		);
</script>
<?php
			
	if (! $inputname) {
?>
<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="" />
<?php

	} else {
?>
<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $inputname; ?>" value="" />
<?php
	}
}

function createCombo($id, $value, $name, $table, $where = " ", $required = true, $isarray = false, $attributeArray = array(), $blank = true) {
	
	if (! $required) {
		echo "<select id='" . $id . "' ";
	
	} else {
		echo "<select required='true' id='" . $id . "' ";
	}
	
	foreach ($attributeArray as $i => $val) {
	    echo "$i='$val' ";
	}
	
	if (! $isarray) {
		echo "name='" . $id . "'>";

	} else {
		echo "name='" . $id . "[]'>";
	}
	
	createComboOptions($value, $name, $table, $where, $blank);
?>	
	</select>
<?php
}
	


function createComboOptions($value, $name, $table, $where = " ", $blank = true) {
	if ($blank) {
		echo "<option value='0'></option>";
	}
		
	$qry = "SELECT A.* 
			FROM $table A 
			$where  
			ORDER BY A.$name";
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			echo "<option value=" . $member[$value] . ">" . $member[$name] . "</option>";
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
}
	
function escape_notes($notes) {
	return str_replace("\r", "", str_replace("'", "\\'", str_replace("\n", "\\n", str_replace("\"", "\\\"", str_replace("\\", "\\\\", $notes)))));
}

function isUserAccessPermitted($action, $description = "") {
	require_once("constants.php");
	
	if ($description == "") {
		$desc = ActionConstants::getActionDescription($action);
		
	} else {
		$desc = $description;
	}
	
	$pageid = $_SESSION['pageid'];
	$memberid = getLoggedOnMemberID();
	$found = 0;
	$actionid = 0;
	$qry = "SELECT A.id 
			FROM {$_SESSION['DB_PREFIX']}applicationactions A 
			WHERE A.pageid = $pageid 
			AND A.code = '$action'";
	$result = mysql_query($qry);
	
	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$found = 1;
			$actionid = $member['id'];
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
	
	if ($found == 0) {
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}applicationactions 
				(
					pageid, code, description, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES
				(
					$pageid, '$action', '$desc', 
					NOW(), $memberid, 
					NOW(), $memberid
				)";
		$result = mysql_query($qry);
		
		if (! $result) {
			logError($qry . " - " . mysql_error());
		}
		
		$actionid = mysql_insert_id();
		
		$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}applicationactionroles 
				(
					actionid, roleid, 
					metacreateddate, metacreateduserid, 
					metamodifieddate, metamodifieduserid
				) 
				VALUES
				(
					$actionid, 'PUBLIC', 
					NOW(), $memberid, 
					NOW(), $memberid
				)";
		$result = mysql_query($qry);
		
		if (! $result) {
			logError($qry . " - " . mysql_error());
		}
	}
	
	$found = 0;
	$roles = ArrayToInClause($_SESSION['ROLES']);
	$qry = "SELECT A.* 
			FROM {$_SESSION['DB_PREFIX']}applicationactionroles A  
			WHERE A.actionid = $actionid 
			AND A.roleid IN ($roles)";
	$result = mysql_query($qry);

	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$found = 1;
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
		
	return $found == 1;
}

function ArrayToInClause($arr) {
	$count = count($arr);
	$str = "";
	
	for ($i = 0; $i < $count; $i++) {
		if ($i > 0) {
			$str = $str . ", ";
		}
		
		$str = $str . "\"" . $arr[$i] . "\"";
	}
	
	return $str;
}

function isUserInRole($roleid) {
	return in_array($roleid, $_SESSION['ROLES']);
}

function redirectWithoutRole($role, $location) {
	start_db();
	
	if (! isUserInRole($role)) {
		header("location: $location");
	}
}

function getEmailHeader() {
	return "<img src='" . getSiteConfigData()->domainurl . "/images/logomain2.png' />";
}

function getEmailFooter() {
	return getSiteConfigData()->emailfooter;
}

function getLoggedOnImageID() {
	return $_SESSION['SESS_IMAGE_ID'];
}

function getLoggedOnMemberID() {
	start_db();
	
	if (! isset($_SESSION['SESS_MEMBER_ID'])) {
		return 0;
	}
	
	return $_SESSION['SESS_MEMBER_ID'];
}

function authenticate() {
	start_db();
	
	if (! isAuthenticated()) {
		header("location: system-login.php?callback=" . base64_encode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']));
		exit();
	}
}

function logError($description, $kill = true) {
	$escdescription = mysql_escape_string($description);
	$memberid = getLoggedOnMemberID();
	
	if ($kill) {
		mysql_query("ROLLBACK");
	}
	
	if (isset($_SESSION['pageid'])) {
		$pageid = $_SESSION['pageid'];
		
	} else {
		$pageid = 1;
	}
	
	$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}errors 
			(
				pageid, memberid, description, 
				metacreateddate, metacreateduserid, 
				metamodifieddate, metamodifieduserid
			) 
			VALUES 
			(
				$pageid, $memberid, '$escdescription', 
				NOW(), $memberid, 
				NOW(), $memberid
			)";
	$result = mysql_query($qry);
	
	if ($kill) {
		die($description);
	}
}

function convertStringToDate($str) {
	if (trim($str) == "") {
		return "";
	}
	
	return substr($str, 6, 4 ) . "-" . substr($str, 3, 2 ) . "-" . substr($str, 0, 2 );
}

function convertStringToDateTime($str) {
	if (trim($str) == "") {
		return "";
	}

	return substr($str, 6, 4 ) . "-" . substr($str, 3, 2 ) . "-" . substr($str, 0, 2 ) . " " . substr($str, 11, 5 );
}

function cms() {
	$pageid = $_SESSION['pageid'];
	$qry = "SELECT content 
			FROM {$_SESSION['DB_PREFIX']}pages 
			WHERE pageid = $pageid";
	$result = mysql_query($qry);

	if ($result) {
		while (($member = mysql_fetch_assoc($result))) {
			echo $member['content'];
		}
		
	} else {
		logError($qry . " - " . mysql_error());
	}
}

function login($login, $password, $redirect = true) {
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	unset($_SESSION['LOGIN_ERRMSG_ARR']);
	unset($_SESSION['ERR_USER']);
	unset($_SESSION['MENU_CACHE']);
			
	//Function to sanitize values received from the form. Prevents SQL injection
	//Sanitize the POST values
	$login = clean($login);
	$password = clean($password);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//Create query
	$md5passwd = md5($password);
	$qry = "SELECT DISTINCT A.* 
		    FROM {$_SESSION['DB_PREFIX']}members A 
		    WHERE A.login = '$login' 
		    AND A.passwd = '$md5passwd'";
	$result = mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lastname'];
			$_SESSION['SESS_IMAGE_ID'] = $member['imageid'];
			
			$memberid = $_SESSION['SESS_MEMBER_ID'];
			
			$qry = "SELECT * 
			        FROM {$_SESSION['DB_PREFIX']}userroles 
			        WHERE memberid = $memberid";
			$result = mysql_query($qry);

			$index = 0;
			$status = null;
			$arr = array();
			$loggedon = getLoggedOnMemberID();
			$arr[$index++] = "PUBLIC";
			
			//Check whether the query was successful or not
			if($result) {
				while($member = mysql_fetch_assoc($result)) {
					$arr[$index++] = $member['roleid'];
				}
				
			} else {
				logError('Failed to connect to server: ' . mysql_error());
			}
			
			$_SESSION['ROLES'] = $arr;
			
			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}loginaudit 
					(
    					memberid, timeon, 
    					metacreateddate, metacreateduserid, 
    					metamodifieddate, metamodifieduserid
					) 
					VALUES 
					(
	    				$memberid, NOW(), 
	    				NOW(), $loggedon, 
	    				NOW(), $loggedon
					)";
			$auditresult = mysql_query($qry);
			$auditid = mysql_insert_id();
			
			$_SESSION['SESS_LOGIN_AUDIT'] = $auditid;
			
			if (! $auditresult) {
				logError("$qry - " . mysql_error());
			}
			
			$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET
					loginauditid = $auditid, 
					metamodifieddate = NOW(), 
					metamodifieduserid = $loggedon
					WHERE member_id = $memberid";
			$auditresult = mysql_query($qry);
			
			if (! $auditresult) {
				logError("$qry - " . mysql_error());
			}
	
			//Create query
			$runscheduledays = getSiteConfigData()->runscheduledays;
			$qry = "SELECT lastschedulerun 
				    FROM {$_SESSION['DB_PREFIX']}siteconfig A 
				    WHERE (lastschedulerun <= (DATE_ADD(CURDATE(), INTERVAL -$runscheduledays DAY)) OR lastschedulerun IS NULL) ";
			$result = mysql_query($qry);
			
			//Check whether the query was successful or not
			if ($result) {
				if(mysql_num_rows($result) == 1) {
					require_once("runalerts.php");
				}
			}
			
			if ($redirect) {
				header("location: index.php");
				exit();
			}
			
		} else {
			//If there are input validations, redirect back to the login form
			if (! $errflag) {
				$errmsg_arr[] = "Invalid login";
			}
			
			$_SESSION['LOGIN_ERRMSG_ARR'] = $errmsg_arr;
			
			//Login failed
			header("location: system-login.php?session=" . urlencode($_GET['session']));
			exit();
		}
		
	}else {
		logError("Query failed :" . mysql_error());
	}
}

function logout() {
	start_db();
									
	if (isAuthenticated()) {
	    $memberid = getLoggedOnMemberID();
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}loginaudit SET 
				timeoff = NOW(), 
				metamodifieddate = NOW(), 
				metamodifieduserid = $memberid
				WHERE id = {$_SESSION['SESS_LOGIN_AUDIT']}";
		$result = mysql_query($qry);
	}
	
	session_unset();
	
	$_SESSION['ROLES'][] = 'PUBLIC';
}

function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}
	
function cache_function($functionname, $arguments = array()) {
//			$stti = microtime(true);
	$encoded = md5(json_encode($arguments));
	$cachekey = 'FNC_CACHE_' . $functionname . "_" . $encoded;
	
	if (! isset($_SESSION[$cachekey]) || $_SESSION['CACHING'] == "false") {
		ob_start(); //Turn on output buffering 
		
		$functionname($arguments);
		
		$_SESSION[$cachekey] = ob_get_clean(); 
//		$fiti = number_format(microtime(true) - $stti, 6);
//		logError("<h1>NONE CACHED $cachekey - ELAPSED $fiti:</h1>", false) ;
		
//	} else {
//		$fiti = number_format(microtime(true) - $stti, 6);
//		logError("<h1>CACHED $cachekey - ELAPSED $fiti</h1>", false) ;
	}
	
	echo $_SESSION[$cachekey];
	
}
?>