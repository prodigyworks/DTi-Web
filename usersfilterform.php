<style>
	.ui-filtertabs-panel {
		min-height:420px;
	}
</style>
<div class="tabs">
  <ul>
    <li><a href="#filtertabs-1">Personal</a></li>
    <li><a href="#filtertabs-2">Emergency</a></li>
    <li><a href="#filtertabs-3">Disclosure Scotland</a></li>
    <li><a href="#filtertabs-10">Experience</a></li>
    <li><a href="#filtertabs-11">Environments</a></li>
  </ul>
  <div id="filtertabs-1">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Login ID</td>
				<td>
					<input required='true' type='text' style='width: 90px' id='filter_login' name='filter_login' />
				</td>
			</tr>
			<tr>
				<td>First Name</td>
				<td>
					<input required='true' type='text' style='width: 150px' id='filter_firstname' name='filter_firstname' />
					<span>Last Name <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 150px' id='filter_lastname' name='filter_lastname' />
					<input type='hidden' style='width: 270px' id='filter_fullname' name='filter_fullname' />
				</td>
			</tr>
			<tr>
				<td>Address 1</td>
				<td>
					<input required='true' type='text' style='width: 300px' id='filter_address1' name='filter_address1' />
				</td>
			</tr>
			<tr>
				<td>Address 2</td>
				<td>
					<input type='text' style='width: 300px' id='filter_address2' name='filter_address2' />
				</td>
			</tr>
			<tr>
				<td>City</td>
				<td>
					<input required='true' type='text' style='width: 120px' id='filter_city' name='filter_city' />
					<span>County / Region <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 120px' id='filter_county' name='filter_county' />
					<span>Post Code <span class='requiredmarker'>*</span></span>
					<input required='true' type='text' style='width: 60px' id='filter_postcode' name='filter_postcode' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 1</td>
				<td>
					<input type='tel' style='width: 128px' id='filter_landline1' name='filter_landline1' required />
				</td>
			</tr>
			<tr>
				<td>Contact Number 2</td>
				<td>
					<input required='true' type='tel' style='width: 128px' id='filter_mobile1' name='filter_mobile1' />
				</td>
			</tr>
			<tr>
				<td>Email 1</td>
				<td>
					<input type='email' style='width: 240px' id='filter_email1' name='filter_email1' />
				</td>
			</tr>
			<tr>
				<td>Email 2</td>
				<td>
					<input type='email' style='width: 240px' id='filter_email2' name='filter_email2' />
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
					<SELECT required id='filter_ukdrivinglicence' name='filter_ukdrivinglicence'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Employment Status</td>
				<td>
					<SELECT required id='filter_employmentstatus' name='filter_employmentstatus'>
						<OPTION value=''></OPTION>
						<OPTION value='D'>Data Techniques Employee</OPTION>
						<OPTION value='C'>Contractor</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
  <div id="filtertabs-2">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Contact</td>
				<td>
					<input required='true' type='text' style='width: 300px' id='filter_emergency_name' name='filter_emergency_name' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 1</td>
				<td>
					<input required='true' type='tel' style='width: 128px' id='filter_emergency_mobile1' name='filter_emergency_mobile1' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 2</td>
				<td>
					<input type='tel' style='width: 128px' id='filter_emergency_mobile2' name='filter_emergency_mobile2' />
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input type='email' style='width: 240px' id='filter_emergency_email1' name='filter_emergency_email1' />
				</td>
			</tr>
			<tr>
				<td>Relationship to you</td>
				<td>
					<input required='true' type='text' style='width: 240px' id='filter_emergency_relationship' name='filter_emergency_relationship' />
				</td>
			</tr>
		</table>
  </div>	
  <div id="filtertabs-3">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Disclosure Scotland</td>
				<td>
					<SELECT required id='filter_disclosure_scotland' name='filter_disclosure_scotland'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT> 
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>What Level</td>
				<td>
					<SELECT required id='filter_disclosure_level' name='filter_disclosure_level'>
						<OPTION value=''></OPTION>
						<OPTION value='B'>Basic</OPTION>
						<OPTION value='S'>Standard</OPTION>
						<OPTION value='E'>Enhanced</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>Date of Issue</td>
				<td>
					<input class='datepicker' type='text' id='filter_disclosure_obtaineddate' name='filter_disclosure_obtaineddate' />
				</td>
			</tr>
			<tr class="disclosure_scotland_div">
				<td>Disclosure Number</td>
				<td>
					<input type='text' style='width: 360px' id='filter_disclosure_refnumber' name='filter_disclosure_refnumber' />
				</td>
			</tr>
		</table>
  </div>
  <div id="filtertabs-10">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>How many years Industry Experience</td>
				<td>
					<input required='true' max='50' min='0' type='number' style='width: 40px' id='filter_experience_years' name='filter_experience_years' />
				</td>
			</tr>
			<tr>
				<td>Date last updated</td>
				<td>
					<input type='text' class='datepicker'id='filter_experience_lastupdateddate' name='filter_experience_lastupdateddate' />
				</td>
			</tr>
		</table>
  </div>
  <div id="filtertabs-11">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='230px'>Banking / Financial</td>
				<td>
					<SELECT required id='filter_environments_banking' name='filter_environments_banking'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Construction Sites</td>
				<td>
					<SELECT required id='filter_environments_buldingsites' name='filter_environments_buldingsites'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Data Centre</td>
				<td>
					<SELECT required id='filter_environments_datacentre' name='filter_environments_datacentre'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Enterprise</td>
				<td>
					<SELECT required id='filter_environments_enterprise' name='filter_environments_enterprise'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>External</td>
				<td>
					<SELECT required id='filter_environments_external' name='filter_environments_external'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>MoD</td>
				<td>
					<SELECT required id='filter_environments_mod' name='filter_environments_mod'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Office</td>
				<td>
					<SELECT required id='filter_environments_office' name='filter_environments_office'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Retail</td>
				<td>
					<SELECT required id='filter_environments_retail' name='filter_environments_retail'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Warehousing</td>
				<td>
					<SELECT required id='filter_environments_warehousing' name='filter_environments_warehousing'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
</div>
