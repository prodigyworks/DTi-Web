<?php
	require_once("crud.php");
	
	class TeamCrud extends Crud {
		
		/* Pre command event. */
		public function preCommandEvent() {
			if (isset($_POST['teamcmd'])) {
				if (isset($_POST['members'])) {
					$counter = count($_POST['members']);
		
				} else {
					$counter = 0;
				}
				
				$teamid = $_POST['teamid'];
				$currentmemberid = getLoggedOnMemberID();
				
				$qry = "DELETE FROM {$_SESSION['DB_PREFIX']}teamuser
						WHERE teamid = $teamid";
				$result = mysql_query($qry);
				
				if (! $result) {
					logError($qry . " - " . mysql_error());
				}
				
				for ($i = 0; $i < $counter; $i++) {
					$memberid = $_POST['members'][$i];
					
					$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}teamuser 
							(
								teamid, memberid, 
								metacreateddate, metacreateduserid, 
								metamodifieddate, metamodifieduserid
							) 
							VALUES 
							(
								$teamid, $memberid, 
								NOW(), $currentmemberid, 
								NOW(), $currentmemberid
							)";
					$result = mysql_query($qry);
					
					if (! $result) {
						logError($qry . " - " . mysql_error());
					}
				};
			}
		}

		/* Post header event. */
		public function postHeaderEvent() {
?>
			<script src='js/jquery.picklists.js' type='text/javascript'></script>
			
			<div id="roleDialog" class="modal">
				<form id="membersForm" name="membersForm" method="post">
					<input type="hidden" id="teamid" name="teamid" />
					<input type="hidden" id="teamcmd" name="teamcmd" value="X" />
					<select class="listpicker" name="members[]" multiple="true" id="members" >
						<?php createComboOptions("member_id", "fullname", "{$_SESSION['DB_PREFIX']}members", "", false); ?>
					</select>
				</form>
			</div>
<?php
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			$(document).ready(function() {
					$("#members").pickList({
							removeText: 'Remove Member',
							addText: 'Add Member',
							testMode: false
						});
					
					$("#roleDialog").dialog({
							autoOpen: false,
							modal: true,
							width: 800,
							title: "Roles",
							buttons: {
								Ok: function() {
									$("#membersForm").submit();
								},
								Cancel: function() {
									$(this).dialog("close");
								}
							}
						});
				});
				
			function userRoles(teamid) {
				getJSONData('findteamusers.php?id=' + teamid, "#members", function() {
					$("#membersForm #teamid").val(teamid);
					$("#roleDialog").dialog("open");
				});
			}
<?php
		}
	}

	$crud = new TeamCrud();
	$crud->title = "Teams";
	$crud->table = "{$_SESSION['DB_PREFIX']}team";
	$crud->dialogwidth = 500;
	$crud->sql = 
			"SELECT A.*, B.fullname
			 FROM {$_SESSION['DB_PREFIX']}team A
			 INNER JOIN {$_SESSION['DB_PREFIX']}members B
			 ON B.member_id = A.memberid
			 ORDER BY A.name";
	
	$crud->columns = array(
			array(
				'name'       => 'id',
				'length' 	 => 6,
				'pk'		 => true,
				'showInView' => false,
				'editable'	 => false,
				'bind' 	 	 => false,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'name',
				'length' 	 => 50,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'memberid',
				'type'       => 'DATACOMBO',
				'length' 	 => 30,
				'label' 	 => 'Team Leader',
				'table'		 => 'members',
				'table_id'	 => 'member_id',
				'alias'		 => 'fullname',
				'table_name' => 'fullname'
			)
		);
	$crud->subapplications = array(
			array(
				'title'		  => 'Team Members',
				'imageurl'	  => 'images/team.png',
				'script' 	  => 'userRoles'
			)
		);
		
	$crud->run();
?>
