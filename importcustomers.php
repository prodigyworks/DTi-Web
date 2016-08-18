<?php
	include("system-header.php"); 

	if (isset($_FILES['importfile']) && $_FILES['importfile']['tmp_name'] != "") {
		if ($_FILES["importfile"]["error"] > 0) {
			echo "Error: " . $_FILES["importfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["importfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["importfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["importfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["importfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		if (($handle = fopen($_FILES['importfile']['tmp_name'], "r")) !== FALSE) {
	        $memberid = getLoggedOnMemberID();
	        
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        $index = 0;
		        
				$name = mysql_escape_string($data[$index++]);
				
		        if ($data[0] != "") {
		        	echo "<div>Customer: $name</div>";

					$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}customer 
							(
								name, street,
								address2, town, city,
								county, postcode, telephone,
								fax, email, contact, notes,
								metacreateddate, metacreateduserid,
								metamodifieddate, metamodifieduserid
							)  
							VALUES  
							(
								'$name', '',
								'', '', '',
								'', '', '',
								'', '', '', '',
								NOW(), $memberid,
								NOW(), $memberid
							)";
							
					$result = mysql_query($qry);
        	
					if (mysql_errno() != 1062 && mysql_errno() != 0 ) {
						logError(mysql_error() . " : " .  $qry);
					}
				}				
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (! isset($_FILES['importfile'])) {
?>	
		
<form class="contentform" method="post" enctype="multipart/form-data">
	<label>Upload customer CSV file </label><br>
	<input type="file" name="importfile" id="importfile" /> 
	
	<br />
	<br />
	 	
	<div id="submit" class="show">
		<input type="submit" value="Upload" />
	</div>
</form>
<?php
	}
	
	include("system-footer.php"); 
?>