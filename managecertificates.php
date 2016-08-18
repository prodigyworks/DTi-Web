<?php
	require_once("crud.php");
	
	class CertificateCrud extends Crud {
		
	}

	$crud = new CertificateCrud();
	$crud->title = "Certificates";
	$crud->table = "{$_SESSION['DB_PREFIX']}certificate";
	$crud->dialogwidth = 500;
	$crud->sql = 
			"SELECT A.*, B.name AS categoryname
			 FROM {$_SESSION['DB_PREFIX']}certificate A
			 INNER JOIN {$_SESSION['DB_PREFIX']}certificatecategory B
			 ON B.id = A.categoryid
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
				'length' 	 => 60,
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
		);
		
	$crud->run();
?>
