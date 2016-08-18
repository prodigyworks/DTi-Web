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
    <li><a href="#tabs-4">Security</a></li>
    <li><a href="#tabs-5">Cabling</a></li>
    <li><a href="#tabs-6">Cabling / Generic</a></li>
    <li><a href="#tabs-7">Electrical</a></li>
    <li><a href="#tabs-8">Safety</a></li>
    <li><a href="#tabs-9">Qualifications</a></li>
    <li><a href="#tabs-10">Experience</a></li>
    <li><a href="#tabs-11">Environments</a></li>
    <li><a href="#tabs-12">Cabling</a></li>
  </ul>
  <div id="tabs-1">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>Login ID</td>
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
				<td>Land Line Number</td>
				<td>
					<input type='tel' style='width: 78px' id='landline1' name='landline1' required />
				</td>
			</tr>
			<tr>
				<td>Mobile Number</td>
				<td>
					<input required='true' type='tel' style='width: 78px' id='mobile1' name='mobile1' />
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
					<input required='true' type='email' style='width: 240px' id='email1' name='email1' />
				</td>
			</tr>
			<tr>
				<td>Image</td>
				<td>
					<img style='padding:5px; border:1px solid black' id='imageid_img' height=60 />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="file" id="imageid" name="imageid" style='width:200px' />
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
				<td width='210px'>Contact</td>
				<td>
					<input required='true' type='text' style='width: 300px' id='emergency_name' name='emergency_name' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 1</td>
				<td>
					<input required='true' type='tel' style='width: 78px' id='emergency_mobile1' name='emergency_mobile1' />
				</td>
			</tr>
			<tr>
				<td>Contact Number 2</td>
				<td>
					<input type='tel' style='width: 78px' id='emergency_mobile2' name='emergency_mobile2' />
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input required='true' type='email' style='width: 240px' id='emergency_email1' name='emergency_email1' />
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
					<textarea class='tinyMCE' id='emergency_notes' name='emergency_notes'></textarea>
				</td>
			</tr>
		</table>
  </div>	
  <div id="tabs-3">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>Disclosure Scotland</td>
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
					<textarea class='tinyMCE' id='disclosure_notes' name='disclosure_notes'></textarea>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-4">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'><b>Security Clearance</b></td>
				<td>
					<table>
						<tr>
							<td width='80px'><b>Yes / No</b></td>
							<td width='180px'><b>Expiry Date</b></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>BPSS</td>
				<td>
					<table>
						<tr>
							<td width='80px'>
								<SELECT required id='security_bpss' name='security_bpss'>
									<OPTION value=''></OPTION>
									<OPTION value='Y'>Yes</OPTION>
									<OPTION value='N'>No</OPTION>
								</SELECT> 
							</td>
							<td width='180px'>
								<input class='datepicker' type='text' id='security_bpssexpiry' name='security_bpssexpiry' />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>SC</td>
				<td>
					<table>
						<tr>
							<td width='80px'>
								<SELECT required id='security_sc' name='security_sc'>
									<OPTION value=''></OPTION>
									<OPTION value='Y'>Yes</OPTION>
									<OPTION value='N'>No</OPTION>
								</SELECT> 
							</td>
							<td width='180px'>
								<input class='datepicker' type='text' id='security_scexpiry' name='security_scexpiry' />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>DV</td>
				<td>
					<table>
						<tr>
							<td width='80px'>
								<SELECT required id='security_dv' name='security_dv'>
									<OPTION value=''></OPTION>
									<OPTION value='Y'>Yes</OPTION>
									<OPTION value='N'>No</OPTION>
								</SELECT> 
							</td>
							<td width='180px'>
								<input class='datepicker' type='text' id='security_dvdate' name='security_dvdate' />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>Who is your sponsor ?</td>
				<td>
					<input type='text' style='width: 360px' id='security_sponsor' name='security_sponsor' />
				</td>
			</tr>
			<tr>
				<td>Notes</td>
				<td>
					<textarea class='tinyMCE' id='security_notes' name='security_notes'></textarea>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-5">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>Commscope</td>
				<td>
					<SELECT required id='cabling_commscope' name='cabling_commscope'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Panduit</td>
				<td>
					<SELECT required id='cabling_panduit' name='cabling_panduit'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Corning</td>
				<td>
					<SELECT required id='cabling_corning' name='cabling_corning'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Brand Rex</td>
				<td>
					<SELECT required id='cabling_brandrex' name='cabling_brandrex'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Excel</td>
				<td>
					<SELECT required id='cabling_excel' name='cabling_excel'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-6">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>City and Guilds</td>
				<td>
					<SELECT required id='cabling_cityandguilds' name='cabling_cityandguilds'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CNET</td>
				<td>
					<SELECT required id='cabling_cnet' name='cabling_cnet'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Other</td>
				<td>
					<SELECT required id='cabling_other' name='cabling_other'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-7">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>CG 2382-10</td>
				<td>
					<SELECT required id='electrical_cg238210' name='electrical_cg238210'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CG 2382-20</td>
				<td>
					<SELECT required id='electrical_cg238220' name='electrical_cg238220'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CG 2391-10</td>
				<td>
					<SELECT required id='electrical_cg239110' name='electrical_cg239110'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CG 2392-10</td>
				<td>
					<SELECT required id='electrical_cg239210' name='electrical_cg239210'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Notes</td>
				<td>
					<textarea class='tinyMCE' id='electrical_notes' name='electrical_notes'></textarea>
				</td>
			</tr>
			<tr>
				<td>Electrical Notes</td>
				<td>
					<textarea class='tinyMCE' id='electrical_electricalnotes' name='electrical_electricalnotes'></textarea>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-8">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>IOSH (Working Safely)</td>
				<td>
					<SELECT required id='safety_ioshworking' name='safety_ioshworking'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>IOSH (Directing Safely)</td>
				<td>
					<SELECT required id='safety_ioshdirecting' name='safety_ioshdirecting'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Ladder (Inspection)</td>
				<td>
					<SELECT required id='safety_ladderinspection' name='safety_ladderinspection'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Ladder (Use Of)</td>
				<td>
					<SELECT required id='safety_ladderuserof' name='safety_ladderuserof'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>SEATS</td>
				<td>
					<SELECT required id='safety_seats' name='safety_seats'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Notes</td>
				<td>
					<textarea class='tinyMCE' id='safety_notes' name='safety_notes'></textarea>
				</td>
			</tr>
			<tr>
				<td>Electrical Notes</td>
				<td>
					<textarea class='tinyMCE' id='safety_safetynotes' name='safety_safetynotes'></textarea>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-9">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>AA</td>
				<td>
					<SELECT required id='qualifications_aa' name='qualifications_aa'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CSCS</td>
				<td>
					<SELECT required id='qualifications_cscs' name='qualifications_cscs'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CPCS</td>
				<td>
					<SELECT required id='qualifications_cpcs' name='qualifications_cpcs'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>CS With BA</td>
				<td>
					<SELECT required id='qualifications_cswithba' name='qualifications_cswithba'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>EFAW</td>
				<td>
					<SELECT required id='qualifications_efaw' name='qualifications_efaw'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>FAW</td>
				<td>
					<SELECT required id='qualifications_faw' name='qualifications_faw'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>IPAF3a</td>
				<td>
					<SELECT required id='qualifications_ipaf3a' name='qualifications_ipaf3a'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>IPAF3b</td>
				<td>
					<SELECT required id='qualifications_ipaf3b' name='qualifications_ipaf3b'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>IPAF PAV</td>
				<td>
					<SELECT required id='qualifications_ipafpav' name='qualifications_ipafpav'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>NRSWA U2 (SLG)</td>
				<td>
					<SELECT required id='qualifications_nrswaslg' name='qualifications_nrswaslg'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>NRSWA (Other)</td>
				<td>
					<SELECT required id='qualifications_nrswaother' name='qualifications_nrswaother'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>PASMA</td>
				<td>
					<SELECT required id='qualifications_pasma' name='qualifications_pasma'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>SMSTS</td>
				<td>
					<SELECT required id='qualifications_smsts' name='qualifications_smsts'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>SSSTS</td>
				<td>
					<SELECT required id='qualifications_sssts' name='qualifications_sssts'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
  </div>
  <div id="tabs-10">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>How many years Industry Experience</td>
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
				<td width='210px'>Junior Field/Pre-Term Copper</td>
				<td>
					<SELECT required id='environments_banking' name='environments_banking'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Building Sites</td>
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
  <div id="tabs-12">
		<table width='100%' cellpadding=0 cellspacing=4 class="entryformclass">
			<tr>
				<td width='210px'>Junior Field/Pre-Term Copper</td>
				<td>
					<SELECT required id='experience_juniorcopper' name='experience_juniorcopper'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Intermediate Field/Pre-Term Copper</td>
				<td>
					<SELECT required id='experience_intermediatecopper' name='experience_intermediatecopper'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Advanced Field/Pre-Term Copper</td>
				<td>
					<SELECT required id='experience_advancedcopper' name='experience_advancedcopper'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<b>MPO Fibre Structured Cabling Systems</b>
				</td>
			</tr>
			<tr>
				<td>Junior MPO Fibre</td>
				<td>
					<SELECT required id='experience_juniormbo' name='experience_juniormbo'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Intermediate MPO Fibre </td>
				<td>
					<SELECT required id='experience_intermediatembo' name='experience_intermediatembo'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Advanced Field/Pre-Term MPO Fibre</td>
				<td>
					<SELECT required id='experience_advancedmbo' name='experience_advancedmbo'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<b>Field Term Fibre Structured Cabling Systems</b>
				</td>
			</tr>
			<tr>
				<td>Junior Field-Term Fibre</td>
				<td>
					<SELECT required id='experience_juniorfibre' name='experience_juniorfibre'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Intermediate Field-Term Fibre</td>
				<td>
					<SELECT required id='experience_intermediatefibre' name='experience_intermediatefibre'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
			<tr>
				<td>Advanced Field/Pre-Term Fibre</td>
				<td>
					<SELECT required id='experience_advancedfibre' name='experience_advancedfibre'>
						<OPTION value=''></OPTION>
						<OPTION value='Y'>Yes</OPTION>
						<OPTION value='N'>No</OPTION>
					</SELECT>
				</td>
			</tr>
		</table>
	</div>
</div>

