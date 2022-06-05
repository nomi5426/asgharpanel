<?php

	/***********************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: CATEGORY MODAL-> CATEGORY MODAL TO DB COMMUNICATION
	* 
	* VARIABLES
	* @PARAM	{STRING}	_CATNAME			//CATEGORY NAME FROM ADDNEWCATEGORY.PHP
	* @PARAM	{STRING}	_MASTERCAT			//CHOSEN MASTER CATEGORY FROM ADDNEWCATEGORY.PHP
	* @PARAM	{INT}		UPLOADSTATUS		//BOOLEAN STATUS
	* @PARAM	{STRING}	INSERT				//SQL STATEMENT
	* @PARAM	{STRING}	RESPONSE			//RESPONSE TO BE SENT IF BOOLEAN IS TRUE
	* @PARAM	{STRING}	CONN				//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE				//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE				//LOG FILE PATH
	* @PARAM	{STRING}	iMAGE_UPLOAD_DIR	//IMAGE DIRECTORY
	* @PARAM	{STRING}	PDF_UPLOAD_DIR		//PDF DIRECTORY
	*
	* FUNCTIONS
	* APP_LOG()									//LOG WRITING
	/***********************************************************************************************/

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	
	//KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
	if(	!isset($_SESSION['_superAdminLogin']) ||
		!isset($_SESSION['_adminLogin'])||
	)
	{
		date_default_timezone_set('Asia/Dubai'); 
		app_log("'".date('d-m-Y H:i:s')."' : Session is not set, 
				Login Attempt From  add_category.php");
		header('Location:../index.php');
	}

	/**
	 * DEFAULT RESPONSE STATUSES THAT BNING SENT BACK TO
	 * ADDNEWCATEGORY.PHP
	 */
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	/**
	 * RETREIVES CATEGORY_NAME AND MASTER_CATEGORY
	 * AS PER THE ENTRY. @PARAM _CATNAME AND @PARAM _MASTERCAT
	 * WILL BE RECEIVING
	 */
	if (isset($_POST['category_name']) || isset($_POST['master_cat']) ){
		$_catName = $_POST['category_name'];
		$_masterCat = $_POST['master_cat'];
		//OPERATION WILL BE PROCESSED WITH @PARAM UPLOADSTATUS
		//WITH A DEFAULT VALUE OF 1
		$uploadStatus = 1; 
		if($uploadStatus = 1){
			//INSERT QUERY
			$insert = $conn->query("INSERT INTO category (category_name,master_cat) VALUES ('".$_catName."','".$_masterCat."')");
			/**
			 * RESPONSE STATUSES WILL BE EDITED AND SEND BACK TO
			 * ADDNEWCATEGORY.PHP
			 */
			if($insert){ 
				$response['status'] = 1;
				$response['message'] = 'Form data submitted successfully!';
				$response['success'] = 'true';
			}
		}
	}
	echo json_encode($response);
	
?>
