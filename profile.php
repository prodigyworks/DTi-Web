<?php 
	include("system-header.php"); 
	showErrors(); 
?>
<h4>User Details</h4>
<!--  Start of content -->
<?php
	$memberid =  getLoggedOnMemberID();
	
	if (isset($_GET['id'])) {
		$memberid = $_GET['id'];
	}
	
	$qry = "SELECT A.* 
			FROM {$_SESSION['DB_PREFIX']}members A 
			WHERE A.member_id = $memberid ";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
?>
	<form id="loginForm" class="manualform" enctype="multipart/form-data" name="loginForm" method="post" action="system-register-exec.php?id=<?php echo $memberid; ?>">
	  <table border="0" align="left" cellspacing=8>
	    <tr>
	      <td>First Name </td>
	      <td><input required="true" name="fname" type="text" class="textfield" id="fname" value="<?php echo $member['firstname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Last Name </td>
	      <td><input required="true" name="lname" type="text" class="textfield" id="lname" value="<?php echo $member['lastname']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>Email Address</td>
	      <td>
	      	<input required="true" name="email1" type="email" class="textfield60" id="email1"  value="<?php echo $member['email1']; ?>" />
	      	<input name="confirmemail" type="hidden" class="textfield60" id="confirmemail" />
	      </td>
	    </tr>
	    <tr>
	      <td>Image</td>
	      <td>
	      
<?php 
			if ($member['imageid'] == 0) {
?>	  
			<img src='images/no-image.gif' height=80 />    
<?php 
			} else {
?>	      
			<img src='system-imageviewer.php?id=<?php echo $member['imageid']; ?>' height=80 style='border:1px solid black' />    
<?php 
			}
?>	      
	      </td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>
	      	<input id="imageid" name="imageid" type="file" />
	      </td>
	    </tr>
	    <tr>
	    	<td colspan="2">
	    		<br />
	    		<h4>Security</h4>
	    		<hr />
	    	</td>
	    </tr>
	    <tr>
	      <td>Password</td>
	      <td><input required="true" name="password" class="pwd" type="password" class="textfield" id="password" /></td>
	    </tr>
	    <tr>
	      <td>Confirm Password </td>
	      <td><input required="true" name="cpassword" type="password" class="textfield" id="cpassword" /></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>
		  	<span class="wrapper"><a class='link1' href="javascript:if (verify()) $('#loginForm').submit();"><em><b>Update</b></em></a></span>
	      </td>
	    </tr>
	  </table>
	  <input required="true" type="hidden" id="description" name="description" value="Profile image" />
	  <input type="hidden" id="description" name="description" value="Profile image" />
	  <script>
	  $(document).ready(
			function() {
<?php
	if (($memberid != $_SESSION['SESS_MEMBER_ID']) && ! isUserInRole("ADMIN")) {
?>
				$("#fname").attr("disabled", true);
				$("#lname").attr("disabled", true);
				$("#email1").attr("disabled", true);
				
<?php
	}
?>	
				$(".pwd").blur(verifypassword);
				$("#email1").blur(checkEmail);
				$("#cpassword").blur(verifycpassword);
				$("#fname").focus();
			});
	
	function verify() {
		var isValid = verifyStandardForm('#loginForm');
		
		if (! verifypassword()) {
			isValid = false;
		}
		
		if (! verifycpassword()) {
			isValid = false;
		}
		
		if (! checkEmail()) {
			isValid = false;
		}
		
		return isValid;
	}
	
	function verifypassword() {
		var node = $(".pwd");
		var str = $(node).val();
		
		return true;
	}
	
	function verifycpassword() {
		var node = $("#cpassword");
		var str = $(node).val();
		
		if ($(node).val() == "") {
			return false;
		}
		
		if( str == $(".pwd").val()) {
			$(node).removeClass("invalid");
			$(node).next().css("visibility", "hidden");
			$(node).next().attr("title", "Required field.");
			
			return true;
			
		} else {
			$(node).addClass("invalid");
			$(node).next().css("visibility", "visible");
			$(node).next().attr("title", "Passwords do not match.");
			
			return false;
		}
	}
	
	
	function checkEmail() {
		var node = $("#email1");
		var returnValue = true;
		
		if ($(node).val() == "") {
			return false;
		}
		
		$("#confirmemail").val(node.val());
		
		callAjax(
				"findemail.php", 
				{ 
					email: $("#email1").val(),
					login: <?php echo $memberid; ?>
				},
				function(data) {
					if (data.length >= 1) {
						$(node).addClass("invalid");
						$(node).next().css("visibility", "visible");
						$(node).next().attr("title", "Email address is already in use by user " + data[0].login + "(" +  data[0].firstname  + " " + data[o].lastname + ").");
						
						returnValue = false;
						
					} else {
						$(node).removeClass("invalid");
						$(node).next().css("visibility", "hidden");
						$(node).next().attr("title", "Required field.");
					}
				},
				false
			);
			
		return returnValue;
	}
</script>
	</form>
<?php
		}
	}
			
?>
<!--  End of content -->

<?php include("system-footer.php"); ?>
