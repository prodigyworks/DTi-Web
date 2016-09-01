<?php
	$where = "";
	
	if (isset($_GET['id']) || isset($_GET['sessionid'])) {
		include("system-embeddedheader.php"); 
		
	} else {
		include("system-header.php"); 
	}
	
	require_once("confirmdialog.php");
	
	function search() {
		global $where;
		
		if ($_POST['pk1'] == "") {
			$where = "";
			
		} else {
			$where = " WHERE MATCH(name, filename) AGAINST ('{$_POST['pk1']}'  IN BOOLEAN MODE) ";
		}
	}
	
	function delete() {
		if (isset($_POST['pk1'])) {
			$id = $_POST['pk1'];
			$qry = "DELETE FROM {$_SESSION['DB_PREFIX']}documents WHERE id = $id";
			$result = mysql_query($qry);
		}
	}
	
	createConfirmDialog("confirmdialog", "Delete document ?", "deleteDocumentFromDialog");
	
	if (isset($_GET['id']) || isset($_GET['sessionid'])) {
?>
<div style='background-color: white'>
<form id="documentForm" name="documentForm" onsubmit="return validate()" enctype="multipart/form-data" method="POST" action="system-documentupload.php?<?php if (isset($_GET['sessionid'])) echo "sessionid=" . $_GET['sessionid']; else echo "id=" . $_GET['id']; if (isset($_GET['documentcallback'])) echo "&documentcallback=" . $_GET['documentcallback'] . "&identifier=" . $_GET['identifier'];?>">
	<div id="documentDiv">
		<label>Title</label>
		<input type="text" id="title" name="title" style="width:550px" /><br>
		<label>Document</label>
		<input type="file" id="document" name="document" style="width:750px" /><br>
		<br>
		<input type="submit" style="margin-left:0px; padding:6px" class="link2"  value="Add Document" id="btnHeanerNotes" />
		<br>
		<br>
	</div>
</form>
</div>
<?php

	} else {
?>
<div id="documentDiv">
<div style='padding:10px'>
	<table cellspacing=8>
		<tr>
			<td>
				<label>SEARCH</label>
			</td>
			<td>
				<input type="text" id="search" name="search" style="width:450px; " />
			</td>
			<td>
				<button id="search" name="search" onclick='search()' style='display:inline; padding:6px' class='link2'>Search</button>
			</td>
		</tr>
	</table>
</div>
<form id="documentForm" name="documentForm" onsubmit="return validate()" enctype="multipart/form-data" method="POST" action="system-documentupload.php">
	<div id="documentDiv">
		<label>TITLE</label>
		<input type="text" id="title" name="title" style="width:550px" /><br>
		<br>
		
		<label>DOCUMENT</label>
		<input type="file" id="document" name="document" style="width:750px" /><br>
		<br>
		<input type="submit" style="margin-left:0px; padding:6px" class="link2"  value="Add Document" id="btnHeanerNotes" />
		<br>
		<br>
</form>
</div>
<?php
	}
?>

<?php
	if (isset($_GET['id']) || isset($_GET['sessionid'])) {
?>
<div style="position: absolute; top: 170px; background-color: white;width: 100%; height:420px; overflow-y: scroll">
<?php
	} else {
?>
<div style="height:290px; overflow-y: scroll">
<?php
	}
?>
	<table class='grid list' id="documentlist" <?php if (! isset($_GET['id']) && ! isset($_GET['sessionid'])) echo 'maxrows=18'; else echo 'maxrows=18';?> width=100% cellspacing=0 cellpadding=0>
		<thead>
			<tr>
				<td width='20px'></td>
<?php
	if (! isset($_GET['id']) && ! isset($_GET['sessionid'])) {
?>
<?php
	}
?>
				<td width='30%'>Name</td>
				<td width='40%'>File Name</td>
				<td width='8%' align='right'>Size</td>
				<td width='7%'>Created</td>
				<td width='15%'>Created By</td>
			</tr>
		</thead>
		<?php
			if (isset($_GET['id'])) {
				$qry = "SELECT A.*, DATE_FORMAT(A.createddate, '%d/%m/%Y') AS createddate, " .
						"DATE_FORMAT(A.lastmodifieddate, '%d/%m/%Y') AS lastmodifieddate, " .
						"B.firstname, B.lastname " .
						"FROM {$_SESSION['DB_PREFIX']}documents A " .
						"INNER JOIN {$_SESSION['DB_PREFIX']}members B " .
						"ON B.member_id = A.createdby " .
						"INNER JOIN {$_SESSION['DB_PREFIX']}" . $_GET['table'] . " C " .
						"ON C.documentid = A.id " .
						"WHERE C." . $_GET['key'] . " = " . $_GET['id'] . " " .
						"ORDER BY A.id";
						
			} else if (isset($_GET['sessionid'])) {
				$qry = "SELECT A.*, DATE_FORMAT(A.createddate, '%d/%m/%Y') AS createddate, " .
						"DATE_FORMAT(A.lastmodifieddate, '%d/%m/%Y') AS lastmodifieddate, " .
						"B.firstname, B.lastname " .
						"FROM {$_SESSION['DB_PREFIX']}documents A " .
						"INNER JOIN {$_SESSION['DB_PREFIX']}members B " .
						"ON B.member_id = A.createdby " .
						"WHERE A.sessionid = '" . $_GET['sessionid'] . "' " .
						"ORDER BY A.id";
						
			} else {
				$qry = "SELECT A.*, DATE_FORMAT(A.createddate, '%d/%m/%Y') AS createddate, " .
						"DATE_FORMAT(A.lastmodifieddate, '%d/%m/%Y') AS lastmodifieddate, " .
						"B.firstname, B.lastname " .
						"FROM {$_SESSION['DB_PREFIX']}documents A " .
						"INNER JOIN {$_SESSION['DB_PREFIX']}members B " .
						"ON B.member_id = A.createdby " .
						$where . " " .
						"ORDER BY A.id";
			}

			$result = mysql_query($qry);
			
			if (! $result) logError("Error: " . mysql_error());
			
			//Check whether the query was successful or not
			if ($result) {
				while (($member = mysql_fetch_assoc($result))) {
					echo "<tr>\n";
					
					if (isUserInRole("ADMIN")) {
						echo "<td width='20px' title='Delete' onclick='deleteDocument(" . $member['id'] . ")'><img src='images/delete.png' /></td>\n";
						
					} else {
						echo "<td width='20px'>&nbsp;</td>\n";
					}
					
					if ($member['name'] == null || trim($member['name']) == "") {
						echo "<td><a target='_new' href='viewdocuments.php?id=" . $member['id'] . "'>" . $member['filename'] . "</a></td>\n";

					} else {
						echo "<td><a target='_new' href='viewdocuments.php?id=" . $member['id'] . "'>" . $member['name'] . "</a></td>\n";
					}
					
					echo "<td>" . $member['filename'] . "</td>\n";
					
					$size = $member['size'];
					
					if ($size > 1073741824) {
						$size = floor($size / 1073741824) . " gb";
						
					} else if ($size > 1048576) {
						$size = floor($size / 1048576) . " mb";
						
					} else if ($size > 1024) {
						$size = floor($size / 1024) . " kb";
						
					} else {
						$size .= " bytes";
					}
					
					echo "<td align='right'>" . $size . "</td>\n";
					echo "<td>" . $member['createddate'] . "</td>\n";
					echo "<td>" . $member['firstname'] . " " . $member['lastname'] . "</td>\n";
					echo "</tr>\n";
				}
				
			} else {
			    logError($qry . " - " . mysql_error());
			}
		?>
	</table>
</div>
<script>
	var selectedDocumentID;
	
	function deleteDocumentFromDialog() {
		call("delete", {pk1: selectedDocumentID});
	}
		
	function search() {
		call("search", {pk1: $("#search").val()});
	}
	
	function deleteDocument(id) {
		selectedDocumentID = id;
		$("#confirmdialog").dialog("open");
	}
	
	function validate() {
		if ($("#title").val() == "") {
			pwAlert("Please enter a title");
			$("#title").focus();
			return false;
		}
		
		if ($("#document").val() == "") {
			pwAlert("Please enter a file");
			$("#document").focus();
			return false;
		}
		
		return true;
	}
		
	$(document).ready(function() {
			$("#document").change(
					function() {
						var val = $(this).val();

						if ($("#title").val() == "") {
							$("#title").val(val.substring(val.lastIndexOf('/') + 1).substring(val.lastIndexOf('\\') + 1));
						}
					}
				);
			
			$("#confirmdialog .confirmdialogbody").html("You are about to remove this document.<br>Are you sure ?");
<?php 
			if (isset($_SESSION['ERRMSG_ARR'])) {
?>
				pwAlert("<?php echo escape_notes($_SESSION['ERRMSG_ARR']); ?>");
<?php
				unset($_SESSION['ERRMSG_ARR']);
			}
?>
		});
</script>
<?php
	if (isset($_GET['id']) || isset($_GET['sessionid']))  {
		include("system-embeddedfooter.php"); 
		
	} else {
		include("system-footer.php"); 
	}
?>
