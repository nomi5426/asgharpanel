<?php

	/*********************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: DB MODEL FOR DATA COMMUNICATION FOR ADDING STAFF
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	* @PARAM	{STRING}	_STAFFNAME							//FETCHED STAFF NAME FROM ADDNEWSTAFF.PHP
	* @PARAM	{STRING}	_STAFFCATEGORY						//FETCHED STAFF CATEGORY FROM ADDNEWSTAFF.PHP
	* @PARAM	{STRING}	_STAFFTYPE							//FETCHED STAFF TYPE FROM ADDNEWSTAFF.PHP
	* @PARAM	{STRING}	UPLOADSTATUS						//DEFAULT UPDLOADSTATUS GIVEN AS 1
	* @PARAM	{STRING}	INSERT								//IF THE QUERY IS INJECTED
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/*********************************************************************************************************/

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	
	//DEFAULT RESPONSES
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	/**
	 * RECEIVES ENTRY FROM ADDNEWSTAFF AND PUSHES IT TO DB. 
	 */
	if (isset($_POST['add_staff_name']) || isset($_POST['staff_category']) || isset($_POST['staff_type']) ){
		$_staffName = $_POST['add_staff_name'];
		$_staffCategory = $_POST['staff_department'];
		$_staffType = $_POST['staff_type'];

		//DB ENTRY
		$uploadStatus = 1; 
		if($uploadStatus = 1){
			$insert = $conn->query("INSERT INTO staff (staff_name,staff_department,staff_type) VALUES ('".$_staffName."','".$_staffCategory."','".$_staffType."')");
			if($insert){ 
				$response['status'] = 1;
				$response['message'] = 'Form data submitted successfully!';
				$response['success'] = 'true';
			}
		}
	}

	echo json_encode($response);

?>
