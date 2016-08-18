<?php
	require_once("crud.php");
	
	function confirmPasswordChange() {
		$memberid = getLoggedOnMemberID();
		$password = mysql_escape_string(md5($_POST['postednewpassword']));
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET 
				passwd = '$password', 
				metamodifieddate = NOW(), 
				metamodifieduserid = $memberid 
				WHERE member_id = {$_POST['expiredmemberid']}";
		$result = mysql_query($qry);
		
		if (! $result) {
			logError($qry . " = " . mysql_error());
		}
	}
	
	function expire() {
		$expiredmemberid = $_POST['expiredmemberid'];
		$memberid = getLoggedOnMemberID();
		
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET 
				status = 'N', 
				metamodifieddate = NOW(), 
				metamodifieduserid = $memberid
				WHERE member_id = $expiredmemberid";
		if (! mysql_query($qry)) {
			logError($qry . " = " . mysql_error());
		}
	}
	
	function live() {
		$expiredmemberid = $_POST['expiredmemberid'];
		$memberid = getLoggedOnMemberID();
		
		$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET 
				status = 'Y', 
				metamodifieddate = NOW(), 
				metamodifieduserid = $memberid
				WHERE member_id = $expiredmemberid";
		if (! mysql_query($qry)) {
			logError($qry . " = " . mysql_error());
		}
	}
	
	class UserCrud extends Crud {
		
		public function editScreenSetup() {
			include("usersform.php");
		}
		
		public function filterScreenSetup() {
			include("usersfilterform.php");
		}
		
		public function postAddScriptEvent() {
?>
			$(".addonly").show();
			$("#fullname").attr("readonly", true);
			$(".addonly input").val("");
			$(".addonly input").attr("required", true);
			$(".tabs").tabs('select', 0);
			$("#disclosure_scotland").trigger("change");
<?php			
		}
		
		public function postEditScriptEvent() {
?>
			$("#fullname").attr("readonly", true);
			$(".addonly input").attr("required", false);
			$(".addonly").hide();
			$(".tabs").tabs('select', 0);
			$("#disclosure_scotland").trigger("change");
<?php			
		}
		
		public function postInsertEvent($id) {
			$passwd = mysql_escape_string(md5($_POST['passwd']));
			$loggedon = getLoggedOnMemberID();
			
			$qry = "UPDATE {$_SESSION['DB_PREFIX']}members SET 
					passwd = '$passwd'
					WHERE member_id = $id";
			if (! mysql_query($qry)) {
				logError($qry . " = " . mysql_error());
			}
			
			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles
					(
						memberid, roleid, 
						metacreateddate, metacreateduserid, 
						metamodifieddate, metamodifieduserid
					) 
					VALUES
					(
						$id, 'PUBLIC', 
						NOW(), $loggedon, 
						NOW(), $loggedon
					)";
			$result = mysql_query($qry);
			
			$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles
					(
						memberid, roleid, 
						metacreateddate, metacreateduserid, 
						metamodifieddate, metamodifieduserid
					) 
					VALUES
					(
						$id, 'USER', 
						NOW(), $loggedon, 
						NOW(), $loggedon
					)";
			$result = mysql_query($qry);
	}
		
		/* Pre command event. */
		public function preCommandEvent() {
			if (isset($_POST['rolecmd'])) {
				if (isset($_POST['roles'])) {
					$counter = count($_POST['roles']);
		
				} else {
					$counter = 0;
				}
				
				$memberid = $_POST['memberid'];
				$currentmemberid = getLoggedOnMemberID();
				$qry = "DELETE FROM {$_SESSION['DB_PREFIX']}userroles 
						WHERE memberid = $memberid";
				
				if (! mysql_query($qry)) {
					logError(mysql_error());
				}
		
				for ($i = 0; $i < $counter; $i++) {
					$roleid = $_POST['roles'][$i];
					
					$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}userroles 
							(
								memberid, roleid, 
								metacreateddate, metacreateduserid, 
								metamodifieddate, metamodifieduserid
							) 
							VALUES 
							(
								$memberid, '$roleid', 
								NOW(), $currentmemberid, 
								NOW(), $currentmemberid
							)";
					$result = mysql_query($qry);
				};
			}
		}

		/* Post header event. */
		public function postHeaderEvent() {
?>
			<script src='js/jquery.picklists.js' type='text/javascript'></script>
			
			<div id="pwdDialog" class="modal">
				<table cellspacing=10>
					<tr>
						<td>
							<label>New Password</label>
						</td>
						<td>
							<input type="password" id="newpassword" />
						</td>
					</tr>
					<tr>
						<td>
							<label>Confirm Password</label>
						</td>
						<td>
							<input type="password" id="confirmnewpassword" />
						</td>
					</tr>
				</table>
			</div>
			<div id="roleDialog" class="modal">
				<form id="rolesForm" name="rolesForm" method="post">
					<input type="hidden" id="memberid" name="memberid" />
					<input type="hidden" id="rolecmd" name="rolecmd" value="X" />
					<select class="listpicker" name="roles[]" multiple="true" id="roles" >
						<?php createComboOptions("roleid", "roleid", "{$_SESSION['DB_PREFIX']}roles", "", false); ?>
					</select>
				</form>
			</div>
<?php
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			var currentRole = null;
			var currentID = null;
			
			function disclosure_scotland_onchange() {
				if ($("#disclosure_scotland").val() == "Y") {
					$(".disclosure_scotland_div").show();
					
					$("#disclosure_level").attr("disabled", false);
					$("#disclosure_obtaineddate").attr("disabled", false);
					$("#disclosure_refnumber").attr("disabled", false);
					$("#disclosure_notes").attr("disabled", false);
					
					$("#disclosure_level").attr("required", true);
					$("#disclosure_obtaineddate").attr("required", true);
					$("#disclosure_refnumber").attr("required", true);
					$("#disclosure_notes").attr("required", true);
				
				} else {
					$(".disclosure_scotland_div").hide();
					
					$("#disclosure_level").attr("disabled", true);
					$("#disclosure_obtaineddate").attr("disabled", true);
					$("#disclosure_refnumber").attr("disabled", true);
					$("#disclosure_notes").attr("disabled", true);
					
					$("#disclosure_level").val("");
					$("#disclosure_obtaineddate").val("");
					$("#disclosure_refnumber").val("");
					$("#disclosure_notes").val("");
					
					$("#disclosure_level").attr("required", false);
					$("#disclosure_obtaineddate").attr("required", false);
					$("#disclosure_refnumber").attr("required", false);
					$("#disclosure_notes").attr("required", false);
				}
			}
			
			$(document).ready(function() {
					$("#disclosure_scotland").change(disclosure_scotland_onchange);
					$("#firstname, #lastname").change(
							function() {
								$("#fullname").val($("#firstname").val() + " " + $("#lastname").val());
							}
						);
					
					$("#roles").pickList({
							removeText: 'Remove Role',
							addText: 'Add Role',
							testMode: false
						});
					
					$("#pwdDialog").dialog({
							autoOpen: false,
							modal: true,
							title: "Password",
							buttons: {
								Ok: function() {
									if ($("#newpassword").val() != $("#confirmnewpassword").val()) {
										pwAlert("Passwords do not match");
										return;
									}
									
									post("editform", "confirmPasswordChange", "submitframe", 
											{ 
												expiredmemberid: currentID,
												postednewpassword: $("#newpassword").val() 
											}
										);
									
									$(this).dialog("close");
								},
								Cancel: function() {
									$(this).dialog("close");
								}
							}
						});
					
					$("#roleDialog").dialog({
							autoOpen: false,
							modal: true,
							width: 800,
							title: "Roles",
							buttons: {
								Ok: function() {
									$("#rolesForm").submit();
								},
								Cancel: function() {
									$(this).dialog("close");
								}
							}
						});
				});
			
			function changePassword(memberid) {
				currentID = memberid;
				
				$("#pwdDialog").dialog("open");
			}
				
			function userRoles(memberid) {
				getJSONData('findroleusers.php?memberid=' + memberid, "#roles", function() {
					$("#memberid").val(memberid);
					$("#roleDialog").dialog("open");
				});
			}
				
			function expire(memberid) {
				post("editform", "expire", "submitframe", 
						{ 
							expiredmemberid: memberid
						}
					);
			}
				
			function live(memberid) {
				post("editform", "live", "submitframe", 
						{ 
							expiredmemberid: memberid
						}
					);
			}
<?php
		}
	}

	$crud = new UserCrud();
	$crud->messages = array(
			array('id'		  => 'expiredmemberid'),
			array('id'		  => 'postednewpassword')
		);
	$crud->subapplications = array(
			array(
				'title'		  => 'User Roles',
				'imageurl'	  => 'images/user.png',
				'script' 	  => 'userRoles'
			),
			array(
				'title'		  => 'Expire',
				'imageurl'	  => 'images/cancel.png',
				'script' 	  => 'expire'
			),
			array(
				'title'		  => 'Live',
				'imageurl'	  => 'images/heart.png',
				'script' 	  => 'live'
			),
			array(
				'title'		  => 'Certificates',
				'imageurl'	  => 'images/accept.png',
				'application' => 'manageusercertificates.php'
			),
			array(
				'title'		  => 'Change Password',
				'imageurl'	  => 'images/lock.png',
				'script' 	  => 'changePassword'
			)
		);

	$crud->dialogwidth = 1150;
	$crud->title = "Users";
	$crud->table = "{$_SESSION['DB_PREFIX']}members";
	
	$crud->sql = 
			"SELECT A.*, B.name
			 FROM {$_SESSION['DB_PREFIX']}members A 
			 LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}customer B
			 ON B.id = A.companyid 
			 ORDER BY A.firstname, A.lastname"; 
			
	$crud->columns = array(
			array(
				'name'       => 'member_id',
				'length' 	 => 6,
				'showInView' => false,
				'bind' 	 	 => false,
				'filter'	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'login',
				'length' 	 => 15,
				'showInView' => false,
				'label' 	 => 'Login ID'
			),
			array(
				'name'       => 'fullname',
				'readonly'	 => true,
				'length' 	 => 45,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'companyid',
				'type'       => 'DATACOMBO',
				'length' 	 => 30,
				'label' 	 => 'Company',
				'table'		 => 'customer',
				'table_id'	 => 'id',
				'alias'		 => 'name',
				'table_name' => 'name'
			),
			array(
				'name'       => 'firstname',
				'length' 	 => 25,
				'showInView' => false,
				'label' 	 => 'First Name'
			),
			array(
				'name'       => 'lastname',
				'length' 	 => 25,
				'showInView' => false,
				'label' 	 => 'Last Name'
			),
			array(
				'name'       => 'address1',
				'length' 	 => 50,
				'label' 	 => 'Address 1'
			),
			array(
				'name'       => 'address2',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Address 2'
			),
			array(
				'name'       => 'city',
				'length' 	 => 20,
				'label' 	 => 'City',
				'showInView' => false
			),
			array(
				'name'       => 'county',
				'length' 	 => 20,
				'label' 	 => 'County',
				'showInView' => false
			),
			array(
				'name'       => 'postcode',
				'length' 	 => 12,
				'label' 	 => 'Post Code'
			),
			array(
				'name'       => 'mobile1',
				'length' 	 => 15,
				'datatype'	 => 'tel',
				'label' 	 => 'Mobile Number'
			),
			array(
				'name'       => 'landline1',
				'length' 	 => 13,
				'datatype'	 => 'tel',
				'showInView' => false,
				'label' 	 => 'Land Line 1'
			),
			array(
				'name'       => 'email1',
				'length' 	 => 40,
				'datatype'	 => 'email',
				'label' 	 => 'Email Address'
			),
			array(
				'name'       => 'imageid',
				'type'       => 'IMAGE',
				'length' 	 => 30,
				'label' 	 => 'Image',
				'showInView' => false
			),
			array(
				'name'       => 'ukdrivinglicence',
				'length' 	 => 12,
				'label' 	 => 'UK Driving Licence',
				'type'       => 'COMBO',
				'showInView' => false,
				'options'    => array(
						array(
							'value'		=> 'Y',
							'text'		=> 'Yes'
						),
						array(
							'value'		=> 'N',
							'text'		=> 'No'
						)
					)
			),
			array(
				'name'       => 'employmentstatus',
				'length' 	 => 12,
				'label' 	 => 'Employment Status',
				'type'       => 'COMBO',
				'showInView' => false,
				'options'    => array(
						array(
							'value'		=> 'D',
							'text'		=> 'Data Techniques Employee'
						),
						array(
							'value'		=> 'C',
							'text'		=> 'Contractor'
						)
					)
			),
			array(
				'name'       => 'emergency_name',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Emergency Contact'
			),
			array(
				'name'       => 'emergency_mobile1',
				'length' 	 => 13,
				'datatype'	 => 'tel',
				'showInView' => false,
				'label' 	 => 'Emergency Mobile 1'
			),
			array(
				'name'       => 'emergency_mobile2',
				'length' 	 => 13,
				'datatype'	 => 'tel',
				'showInView' => false,
				'label' 	 => 'Emergency Mobile 2'
			),
			array(
				'name'       => 'emergency_landline1',
				'length' 	 => 13,
				'datatype'	 => 'tel',
				'showInView' => false,
				'label' 	 => 'Emergency Land Line 1'
			),
			array(
				'name'       => 'emergency_landline2',
				'length' 	 => 13,
				'datatype'	 => 'tel',
				'showInView' => false,
				'label' 	 => 'Emergency Land Line 2'
			),
			array(
				'name'       => 'emergency_email1',
				'length' 	 => 40,
				'datatype'	 => 'email',
				'showInView' => false,
				'label' 	 => 'Emergency Email 1'
			),
			array(
				'name'       => 'emergency_email2',
				'length' 	 => 40,
				'showInView' => false,
				'datatype'	 => 'email',
				'label' 	 => 'Emergency Email 2'
			),
			array(
				'name'       => 'emergency_relationship',
				'length' 	 => 40,
				'showInView' => false,
				'label' 	 => 'Emergency Relationship'
			),
			array(
				'name'       => 'emergency_notes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Emergency Notes'
			),
			array(
				'name'       => 'disclosure_scotland',
				'length' 	 => 12,
				'label' 	 => 'Disclosure Scotland',
				'onchange'	 => 'disclosure_scotland_onchange',
				'showInView' => false,
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'Y',
							'text'		=> 'Yes'
						),
						array(
							'value'		=> 'N',
							'text'		=> 'No'
						)
					)
			),
			array(
				'name'       => 'disclosure_level',
				'length' 	 => 12,
				'label' 	 => 'What Level',
				'required' 	 => false,
				'showInView' => false,
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'B',
							'text'		=> 'Basic'
						),
						array(
							'value'		=> 'S',
							'text'		=> 'Standard'
						),
						array(
							'value'		=> 'E',
							'text'		=> 'Enhanced'
						)
					)
			),
			array(
				'name'       => 'disclosure_obtaineddate',
				'length' 	 => 40,
				'showInView' => false,
				'required' 	 => false,
				'datatype'	 => 'date',
				'label' 	 => 'Obtained Date'
			),
			array(
				'name'       => 'disclosure_refnumber',
				'length' 	 => 60,
				'showInView' => false,
				'required' 	 => false,
				'label' 	 => 'Reference Number'
			),
			array(
				'name'       => 'disclosure_notes',
				'length' 	 => 60,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'required' 	 => false,
				'label' 	 => 'Notes'
			),
			array(
				'name'       => 'security_bpss',
				'length' 	 => 8,
				'showInView' => false,
				'label' 	 => 'BPSS'
			),
			array(
				'name'       => 'security_bpssexpiry',
				'datatype'	 => 'date',
				'length' 	 => 12,
				'showInView' => false,
				'label' 	 => 'Expiry Date'
			),
			array(
				'name'       => 'security_sc',
				'length' 	 => 8,
				'showInView' => false,
				'label' 	 => 'SC'
			),
			array(
				'name'       => 'security_scexpiry',
				'datatype'	 => 'date',
				'length' 	 => 12,
				'showInView' => false,
				'label' 	 => 'Expiry Date'
			),
			array(
				'name'       => 'security_dv',
				'length' 	 => 8,
				'showInView' => false,
				'label' 	 => 'DV'
			),
			array(
				'name'       => 'security_dvdate',
				'datatype'	 => 'date',
				'length' 	 => 12,
				'showInView' => false,
				'label' 	 => 'Expiry Date'
			),
			array(
				'name'       => 'security_sponsor',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Sponsor'
			),
			array(
				'name'       => 'security_notes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Notes'
			),
			array(
				'name'       => 'cabling_commscope',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling Comms'
			),
			array(
				'name'       => 'cabling_panduit',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling Panduit'
			),
			array(
				'name'       => 'cabling_corning',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling Corning'
			),
			array(
				'name'       => 'cabling_brandrex',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling Brand Rex'
			),
			array(
				'name'       => 'cabling_excel',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling Excel'
			),
			array(
				'name'       => 'cabling_cityandguilds',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Cabling City and Guilds'
			),
			array(
				'name'       => 'cabling_cnet',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'cabling_other',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'electrical_cg238210',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'electrical_cg238220',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'electrical_cg239110',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'electrical_cg239210',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'electrical_notes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Notes'
			),
			array(
				'name'       => 'electrical_electricalnotes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Notes'
			),
			array(
				'name'       => 'safety_ioshworking',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'safety_ioshdirecting',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'safety_ladderinspection',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'safety_ladderuserof',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'safety_seats',
				'length' 	 => 2,
				'showInView' => false,
				'label' 	 => 'Comms'
			),
			array(
				'name'       => 'safety_notes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Notes'
			),
			array(
				'name'       => 'safety_safetynotes',
				'length' 	 => 40,
				'type'		 => 'TEXTAREA',
				'showInView' => false,
				'label' 	 => 'Notes'
			),			
			array(
				'name'       => 'qualifications_aa',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_cscs',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_cpcs',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_cswithba',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_efaw',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_faw',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_ipaf3a',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_ipaf3b',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_ipafpav',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_nrswaslg',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_nrswaother',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_pasma',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_smsts',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'qualifications_sssts',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_banking',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_buldingsites',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_datacentre',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_enterprise',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_external',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_mod',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_office',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_retail',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'environments_warehousing',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_years',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_lastupdateddate',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_juniorcopper',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_intermediatecopper',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_advancedcopper',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_juniormbo',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_intermediatembo',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_advancedmbo',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_juniorfibre',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_intermediatefibre',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			),
			array(
				'name'       => 'experience_advancedfibre',
				'length' 	 => 50,
				'showInView' => false,
				'label' 	 => 'Reference'
			)
		);
				
	$crud->run();
?>