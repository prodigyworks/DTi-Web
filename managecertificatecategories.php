<?php
	require_once("crud.php");
	
	class CertificateTypeCrud extends Crud {
		
	}

	$crud = new CertificateTypeCrud();
	$crud->title = "Qualification Categories";
	$crud->table = "{$_SESSION['DB_PREFIX']}certificatecategory";
	$crud->dialogwidth = 500;
	$crud->sql = 
			"SELECT A.*
			 FROM {$_SESSION['DB_PREFIX']}certificatecategory A
			 ORDER BY A.name";
	
	$crud->columns = array(
			array(
				'name'       => 'id',
				'length' 	 => 6,
				'filter'	 => false,
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
		);
		
	$crud->run();
?>
