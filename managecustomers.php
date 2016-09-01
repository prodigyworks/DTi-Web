<?php
	require_once("crud.php");
	
	class CustomerCrud extends Crud {

		public function postScriptEvent() {
?>
			/* Derived address callback. */
			function fullAddress(node) {
				var address = "";
				
				if (node.street != null && node.street != "") {
					address = address + node.street;
				} 
				
				if (node.address2 != null && node.address2 != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.address2;
				} 
				
				if (node.town != null && node.town != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.town;
				} 
				
				if (node.city != null && node.city != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.city;
				} 
				
				if (node.county != null && node.county != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.county;
				} 
				
				if (node.postcode != null && node.postcode != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.postcode;
				} 
				
				if (node.postcode != null && node.postcode != "") {
					if (address != "") {
						address = address + ", ";
					}
					
					address = address + node.postcode;
				} 
				
				return address;
			}
<?php			
		}
	}
	
	$crud = new CustomerCrud();
	$crud->dialogwidth = 770;
	$crud->title = "Contractors";
	$crud->table = "{$_SESSION['DB_PREFIX']}customer";
	$crud->sql = "SELECT A.*
				  FROM  {$_SESSION['DB_PREFIX']}customer A
				  ORDER BY A.name";
	$crud->columns = array(
			array(
				'name'       => 'id',
				'viewname'   => 'uniqueid',
				'length' 	 => 6,
				'showInView' => false,
				'filter'	 => false,
				'bind' 	 	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'name',
				'length' 	 => 40,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'street',
				'length' 	 => 60,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Address 1'
			),
			array(
				'name'       => 'address2',
				'length' 	 => 60,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Address 2'
			),
			array(
				'name'       => 'town',
				'length' 	 => 30,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Town'
			),
			array(
				'name'       => 'city',
				'length' 	 => 30,
				'required'	 => false,
				'showInView' => false,
				'label' 	 => 'City'
			),
			array(
				'name'       => 'county',
				'length' 	 => 30,
				'required'	 => false,
				'showInView' => false,
				'label' 	 => 'County'
			),
			array(
				'name'       => 'postcode',
				'length' 	 => 10,
				'required'	 => false,
				'showInView' => false,
				'label' 	 => 'Post Code'
			),
			array(
				'name'       => 'address',
				'length' 	 => 90,
				'editable'   => false,
				'required'	 => false,
				'bind'		 => false,
				'type'		 => 'DERIVED',
				'function'	 => 'fullAddress',
				'label' 	 => 'Address'
			),
			array(
				'name'       => 'email',
				'required'	 => false,
				'showInView' => false,
				'length' 	 => 70,
				'datatype'	 => 'email',
				'label' 	 => 'Email'
			),
			array(
				'name'       => 'website',
				'required'	 => false,
				'length' 	 => 60,
				'datatype'	 => 'url',
				'label' 	 => 'Web Site Address'
			),
			array(
				'name'       => 'telephone',
				'length' 	 => 18,
				'required'	 => false,
				'datatype'	 => 'tel',
				'label' 	 => 'Telephone'
			),
			array(
				'name'       => 'fax',
				'length' 	 => 18,
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Fax'
			),
			array(
				'name'       => 'contact',
				'length' 	 => 70,
				'required'	 => false,
				'showInView' => false,
				'label' 	 => 'Contact'
			),			
			array(
				'name'       => 'notes',
				'length' 	 => 50,
				'type'		 => 'BASICTEXTAREA',
				'showInView' => false,
				'required'	 => false,
				'label' 	 => 'Notes'
			)
		);
	
	$crud->run();
?>
