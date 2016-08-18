<?php
	require_once("crud.php");
	
	class CertificateCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		/* Post script event. */
		public function postScriptEvent() {
?>
			function editDocuments(node) {
				viewDocument(node, "addusercertdocument.php", node, "usercertificatedocs", "usercertificateid");
			}
			
			function certificateid_onchange() {
				callAjax(
						"finddata.php", 
						{ 
							sql: "SELECT expires, cardnumberrequired " +
								 "FROM <?php echo $_SESSION['DB_PREFIX'];?>certificate " + 
								 "WHERE id = " + $(this).val()
						},
						function(data) {
							var node = data[0];
							
							if (node.cardnumberrequired == "Y") {
								$("#sponsor").attr("required", true);
								$("#sponsor").attr("disabled", false);
								
							} else {
								$("#sponsor").attr("required", false);
								$("#sponsor").attr("disabled", true);
								$("#sponsor").val("");
							}
							
							if (node.expires == "Y") {
								$("#validyears").attr("required", true);
								
							} else {
								$("#validyears").attr("required", false);
							}
						},
						false
					);
			}
			
			function categoryid_onchange() {
				$.ajax({
						url: "createcertificatecombo.php",
						dataType: 'html',
						async: false,
						data: { 
							categoryid: $("#categoryid").val()
						},
						type: "POST",
						error: function(jqXHR, textStatus, errorThrown) {
							pwAlert("ERROR :" + errorThrown);
						},
						success: function(data) {
							$("#certificateid").html(data);
						}
					});
			}
<?php
		}
	}

	$crud = new CertificateCrud();
	$crud->title = "Certificates";
	$crud->table = "{$_SESSION['DB_PREFIX']}usercertificate";
	$crud->dialogwidth = 800;
	$crud->sql = 
			"SELECT 
			 A.*, 
			 B.categoryid, B.name, B.expires, 
			 C.name AS categoryname,
			 D.fullname
			 FROM {$_SESSION['DB_PREFIX']}usercertificate A
			 INNER JOIN {$_SESSION['DB_PREFIX']}certificate B
			 ON B.id = A.certificateid
			 INNER JOIN {$_SESSION['DB_PREFIX']}certificatecategory C
			 ON C.id = B.categoryid
			 INNER JOIN {$_SESSION['DB_PREFIX']}members D
			 ON D.member_id = A.memberid
			 WHERE A.memberid = {$_GET['id']}
			 ORDER BY B.name";
	
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
				'name'       => 'memberid',
				'type'       => 'DATACOMBO',
				'length' 	 => 30,
				'editable'	 => false,
				'default'	 => $_GET['id'],
				'label' 	 => 'User',
				'table'		 => 'members',
				'table_id'	 => 'member_id',
				'alias'		 => 'fullname',
				'table_name' => 'fullname'
			),
			array(
				'name'       => 'categoryid',
				'type'       => 'DATACOMBO',
				'length' 	 => 30,
				'onchange'	 => 'categoryid_onchange',
				'bind'	 	 => false,
				'label' 	 => 'Category',
				'table'		 => 'certificatecategory',
				'table_id'	 => 'id',
				'alias'		 => 'categoryname',
				'table_name' => 'name'
			),
			array(
				'name'       => 'certificateid',
				'type'       => 'DATACOMBO',
				'length' 	 => 70,
				'onchange'	 => 'certificateid_onchange',
				'label' 	 => 'Certificate',
				'table'		 => 'certificate',
				'table_id'	 => 'id',
				'alias'		 => 'name',
				'table_name' => 'name'
			),
			array(
				'name'       => 'datetaken',
				'length' 	 => 15,
				'datatype'	 => 'date',
				'label' 	 => 'Date taken'
			),
			array(
				'name'       => 'validyears',
				'length' 	 => 15,
				'align'		 => 'right',
				'datatype'	 => 'integer',
				'label' 	 => 'Valid (years)'
			),
			array(
				'name'       => 'sponsor',
				'length' 	 => 12,
				'label' 	 => 'Sponsor',
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'A',
							'text'		=> 'Aspire'
						),
						array(
							'value'		=> 'B',
							'text'		=> 'BT'
						),
						array(
							'value'		=> 'H',
							'text'		=> 'HMRC'
						),
						array(
							'value'		=> 'O',
							'text'		=> 'Other'
						)
					)
			),
			array(
				'name'       => 'notes',
				'showInView' => false,
				'length' 	 => 15,
				'type'	 	 => 'BASICTEXTAREA',
				'label' 	 => 'Notes'
			),
		);
		
	$crud->subapplications = array(
			array(
				'title'		  => 'Documents',
				'imageurl'	  => 'images/document.gif',
				'script' 	  => 'editDocuments'
			)
		);
				
		
	$crud->run();
?>
