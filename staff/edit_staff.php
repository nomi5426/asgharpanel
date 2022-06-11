<?php

	/*********************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: DB MODEL FOR DATA COMMUNICATION FOR EDIT STAFF FROM EDITSTAFF.PHP
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	* @PARAM	{STRING}	ID									//EDITED STAFF ID FETCH FROM EDITSTAFF.PHP
	* @PARAM	{STRING}	STAFFNAME							//NEW STAFF NAME ENTERED FROM EDITSTAFF.PHP
	* @PARAM	{STRING}	_STAFFASSOCIATE						//CHECK ORDER_STAFF TABLE IF THE STAFF IS EDITED IS ADDED FOR AN ORDER ALREADY
	* @PARAM	{STRING}	STAFF_NAME							//QUERY TO GET STAFF
	* @PARAM	{STRING}	_DBSTAFF_NAME						//VARIABLE TO CHECK STAFF FROM DB
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/*********************************************************************************************************/

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';

	//DEFAULT RESPONSE STATUS
	$response['status'] = 0;

	//EDIT CATEGORY - RETREIVES STAFF ID AND NAME 
	if(isset($_POST['id']) || isset($_POST['e_staffname'])){
		$id = $_POST['id'];
		$staffName = $_POST['e_staffname'];
		//CHECK IF STAFF IS ASSOCIATED WITH ORDERS
		$_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE staff_id = ".$id);

		//GET STAFF NAME
		$staff_Name=mysqli_query($conn,"SELECT * FROM staff WHERE id = ".$id);
		$_dbStaff_name='';
		while($row = mysqli_fetch_array($staff_Name)){
			$_dbStaff_name .=$row['staff_name'];
		}

		//CATEGOTY IS NOT ASSOCIATED WITH ORDERS
		if(mysqli_num_rows($_staffAssociate)!=0){
			$response['status'] = 3;
		}
		else{
			if($staffName != $_dbStaff_name){
				$_update = $conn->query("UPDATE staff SET staff_name = '".$staffName."' WHERE id = ".$id);
				if($_update){
					$response['status'] = 1;
				}
			}else{
				$response['status'] = 2;
			}
		}
	}
	
	echo json_encode($response);

?>

