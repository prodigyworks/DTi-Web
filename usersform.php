<style>
	.ui-tabs-panel {
		min-height:420px;
	}
</style>
<div class="tabs">
  <ul>
    <li><a href="#tabs-1">Personal</a></li>
    <li><a href="#tabs-2">Emergency</a></li>
    <li><a href="#tabs-3">Disclosure Scotland</a></li>
    <li><a href="#tabs-10">Experience</a></li>
    <li><a href="#tabs-11">Environments</a></li>
  </ul>
  <div id="tabs-1">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Login ID</td>
				<td>
					<input required='true' type='text' style='width: 90px' id='login' name='login' />
				</td>
			</tr>
			<tr class="addonly">
				<td>Password</td>
				<td>
					<input required='true' type='password' style='width: 180px' id='passwd' name='passwd' />
				</td>
			</tr>
			<tr class="addonly">
				<td>Confirm Password</td>
				<td>
					<input required='true' type='password' style='width: 180px' id='cpassword' name='cpassword' /></td>
			</tr>
			<tr>
				<td>First Name</td>
				<td>
					<input required='true' type='text' style='width: 150px' id='firstname' name='firstname' />
					<span>Last Name <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 150px' id='lastname' name='lastname' />
					<input type='hidden' style='width: 270px' id='fullname' name='fullname' />
				</td>
			</tr>
			<tr>
				<td>Address 1</td>
				<td>
					<input required='true' type='text' style='width: 300px' id='address1' name='address1' />
				</td>
			</tr>
			<tr>
				<td>Address 2</td>
				<td>
					<input type='text' style='width: 300px' id='address2' name='address2' />
				</td>
			</tr>
			<tr>
				<td>City</td>
				<td>
					<input required='true' type='text' style='width: 120px' id='city' name='city' />
					<span>County / Region <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 120px' id='county' name='county' />
					<span>Post Code <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 60px' id='postcode' name='postcode' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 1</td>
				<td>
					<input type='tel' style='width: 128px' id='landline1' name='landline1' required />
				</td>
			</tr>
			<tr>
				<td>Contact Number 2</td>
				<td>
					<input required='true' type='tel' style='width: 128px' id='mobile1' name='mobile1' />
				</td>
			</tr>
			<tr>
				<td>Email 1</td>
				<td>
					<input type='email' style='width: 240px' id='email1' name='email1' />
				</td>
			</tr>
			<tr>
				<td>Email 2</td>
				<td>
					<input type='email' style='width: 240px' id='email2' name='email2' />
				</td>
			</tr>
			<tr>
				<td>Image</td>
				<td>
					<img style='padding:5px; border:1px solid black' id='imageid_img' alt="Profile Image" class="imageviewer" height=60 />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="file" id="imageid" name="imageid" style='width:200px' />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<b>NOTE: Image will not be refreshed until the record is saved.</b>
				</td>
			</tr>
			<tr>
				<td>Company</td>
				<td>
					<?php createCombo("companyid", "id", "name", "{$_SESSION['DB_PREFIX']}customer"); ?>
				</td>
			</tr>
			<tr>
				<td>UK Driving Licence</td>
				<td>
					<SELECT required id='ukdrivinglicence' name='ukdrivinglicence'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Employment Status</td>
				<td>
					<SELECT required id='employmentstatus' name='employmentstatus'>
						<OPTION value=''></OPTION>
						<OPTION value='D'>Data Techniques Employee</OPTION>
						<OPTION value='C'>Contractor</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-2">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Contact</td>
				<td>
					<input required='true' type='text' style='width: 300px' id='emergency_name' name='emergency_name' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 1</td>
				<td>
					<input required='true' type='tel' style='width: 128px' id='emergency_mobile1' name='emergency_mobile1' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 2</td>
				<td>
					<input type='tel' style='width: 128px' id='emergency_mobile2' name='emergency_mobile2' />
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input type='email' style='width: 240px' id='emergency_email1' name='emergency_email1' />
				</td>
			</tr>
			<tr>
				<td>Relationship to you</td>
				<td>
					<input required='true' type='text' style='width: 240px' id='emergency_relationship' name='emergency_relationship' />
				</td>
			</tr>
			<tr>
				<td>Notes</td>
				<td>
					<textarea cols=80 rows=7 id='emergency_notes' name='emergency_notes'></textarea>
				</td>
			</tr>
		</table>
  </div>	
  <div id="tabs-3">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Disclosure Scotland</td>
				<td>
					<SELECT required id='disclosure_scotland' name='disclosure_scotland'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT> 
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>What Level</td>
				<td>
					<SELECT required id='disclosure_level' name='disclosure_level'>
						<OPTION value=''></OPTION>
						<OPTION value='B'>Basic</OPTION>
						<OPTION value='S'>Standard</OPTION>
						<OPTION value='E'>Enhanced</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>Obtained Date</td>
				<td>
					<input class='datepicker' type='text' id='disclosure_obtaineddate' name='disclosure_obtaineddate' />
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>Reference Number</td>
				<td>
					<input type='text' style='width: 360px' id='disclosure_refnumber' name='disclosure_refnumber' />
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>Notes</td>
				<td>
					<textarea cols=80 rows=7 id='disclosure_notes' name='disclosure_notes'></textarea>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-10">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>How many years Industry Experience</td>
				<td>
					<input required='true' max='50' min='0' type='number' style='width: 40px' id='experience_years' name='experience_years' />
				</td>
			</tr>
			<tr>
				<td>Date last updated</td>
				<td>
					<input type='text' class='datepicker'id='experience_lastupdateddate' name='experience_lastupdateddate' />
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-11">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Banking / Financial</td>
				<td>
					<SELECT required id='environments_banking' name='environments_banking'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Construction Sites</td>
				<td>
					<SELECT required id='environments_buldingsites' name='environments_buldingsites'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Data Centre</td>
				<td>
					<SELECT required id='environments_datacentre' name='environments_datacentre'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Enterprise</td>
				<td>
					<SELECT required id='environments_enterprise' name='environments_enterprise'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>External</td>
				<td>
					<SELECT required id='environments_external' name='environments_external'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>MoD</td>
				<td>
					<SELECT required id='environments_mod' name='environments_mod'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Office</td>
				<td>
					<SELECT required id='environments_office' name='environments_office'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Retail</td>
				<td>
					<SELECT required id='environments_retail' name='environments_retail'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Warehousing</td>
				<td>
					<SELECT required id='environments_warehousing' name='environments_warehousing'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
</div>
<script>
	attachImageView("imageid_img");
</script>