<?php
	require_once("crud.php");
	
	class CertificateCrud extends Crud {
		
	}

	$crud = new CertificateCrud();
	$crud->title = "Qualifications";
	$crud->table = "{$_SESSION['DB_PREFIX']}certificate";
	$crud->dialogwidth = 800;
	$crud->sql = 
			"SELECT A.*, B.name AS categoryname
			 FROM {$_SESSION['DB_PREFIX']}certificate A
			 INNER JOIN {$_SESSION['DB_PREFIX']}certificatecategory B
			 ON B.id = A.categoryid
			 ORDER BY B.name, A.name";
	
	$crud->columns = array(
			array(
				'name'       => 'id',
				'length' 	 => 6,
				'pk'		 => true,
				'filter'	 => false,
				'showInView' => false,
				'editable'	 => false,
				'bind' 	 	 => false,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'name',
				'length' 	 => 90,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'categoryid',
				'type'       => 'DATACOMBO',
				'length' 	 => 30,
				'label' 	 => 'Category',
				'table'		 => 'certificatecategory',
				'table_id'	 => 'id',
				'alias'		 => 'categoryname',
				'table_name' => 'name'
			),
			array(
				'name'       => 'expires',
				'length' 	 => 12,
				'label' 	 => 'Expires',
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
				'name'       => 'cardnumberrequired',
				'length' 	 => 21,
				'label' 	 => 'Card Number Required',
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
			)
		);
		
	$crud->run();
?>
