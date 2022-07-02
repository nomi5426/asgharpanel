<?php

	/***************************************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: MANUAL ORDER ADDING DB MANAGMENT / RELATED FILE - 
	*			PUSHED FROM AND GOES TO ADDNEWORDER.PHP
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	* @PARAM	{STRING}	RESPONSE							//DEFAULT RESPONSE
	* @PARAM	{STRING}	SQL									//SQL STATEMENT
	* @PARAM	{STRING}	QUERY								//SQLI PARAM TO IMPLEMENT QUERY
	* @PARAM	{STRING}	_OUTPUT								//RETURN DATA TO SOURCE DIRECTORY
	* @PARAM	{STRING}	CODESDIR							//QR CODE FILE DIRECTORY
	* @PARAM	{STRING}	IMAGE_UPLOAD_DIR					//IMAGE FILE DIRECTORY
	* @PARAM	{STRING}	PDF_UPLOAD_DIR						//DELIVERY NOTE FILE DIRECTORY
	* @PARAM	{STRING}	CODESDIR							//QR CODE FILE DIRECTORY
	* @PARAM	{STRING}	CODEFILE							//QR CODE FILE NAME - INV ID + ITEM NAME
	* @PARAM	{STRING}	FORMDATA							//QR CODE URL FOR SEARCHING
	* @PARAM	{STRING}	INVOCIE								//SET USER INPUT - INVOICE ID
	* @PARAM	{STRING}	DD									//SET USER INPUT - DELIVERY DATE WITH CUSTOM FORMAT
	* @PARAM	{STRING}	ITEMNAME							//SET USER INPUT - ITEM NAME
	* @PARAM	{STRING}	COLOR								//SET USER INPUT - COLOR
	* @PARAM	{STRING}	SIZE								//SET USER INPUT - SIZE
	* @PARAM	{STRING}	FROM								//SET USER INPUT - FROM LOCATION
	* @PARAM	{STRING}	DELIVERYLOCATION					//SET USER INPUT - DELIVERYLOCATION
	* @PARAM	{STRING}	STATUS								//SET USER INPUT - STATUS
	* @PARAM	{STRING}	QUANTITY							//SET USER INPUT - QUANTITY
	* @PARAM	{STRING}	ORDERNOTE							//SET USER INPUT - ORDERNOTE
	* @PARAM	{STRING}	SALESCONSULTANT						//SET USER INPUT - SALESCONSULTANT
	* @PARAM	{STRING}	CAT_ID								//SET USER INPUT - CAT_ID
	* @PARAM	{STRING}	DELIVERYDATE						//SET USER INPUT - DELIVERYDATE
	* @PARAM	{STRING}	INSERTDATE							//CURRENT DATE
	* @PARAM	{STRING}	USERID								//FIND CURRENT USER
	* @PARAM	{STRING}	DELIVERYDATETOSEC					//CONVERT DELIVERY DATE TO SECOND
	* @PARAM	{STRING}	INSERTDATETOSEC						//CONVERT INSERT DATE TO SECOND
	* @PARAM	{STRING}	TIMEDIFF							//FIND THE DIFFERENCE BETWEEN INSERT DATE AND DELIVERY DATE
	* @PARAM	{STRING}	DATEAVAILABILITY					//DEDUCTING IT AND GET THE AVAILABLE DAYS
	* @PARAM	{STRING}	IMAGENAME							//DECLARED IMAGE NAME - EMPTY
	* @PARAM	{STRING}	IMAGE								//DECLARED IMAGE NAME - SET IMG NAME WITH A RANDOM STRING
	* @PARAM	{STRING}	IMGTMPNAME							//DECLARED TEMPORARY IMAGE NAME
	* @PARAM	{STRING}	NAME								//GENERATE RANDOM NUMBERS WITH 3 DIGITS
	* @PARAM	{STRING}	RANDOM								//RANDOM PARAMETER WHICH SHUFFLES NUMBERS
	* @PARAM	{STRING}	RESULT								//SAVES IMAGE TO IMAGE DIRECTORY
	* @PARAM	{STRING}	_PDFDN								//DECLARED DELIVERY NOTE NAME - EMPTY
	* @PARAM	{STRING}	_DNTMP								//DECLARED TEMPORARY DELIVERY NOTE NAME
	* @PARAM	{STRING}	INSERT								//SQL INJECTING STATETMENT TO ADD RECORDS OF AN ORDER
	* @PARAM	{STRING}	RESPONSE							//RESPONSE SEND TO ADDNEWORDER.PHP
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/****************************************************************************************************************************/

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	include('../library/phpqrcode/qrlib.php'); 
	$codesDir = "../qrcodes/";	
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	$swatch_upload_dir = '../swatchUploads/';

	/**
	 * SAVES QR WITH ITS FILE NAME IF POST RECEIVES, 
	 * ELSE LOCATE TO INDEX
	 */
	if(isset($_POST) && !empty($_POST)) {
		$codeFile = $_POST['_newInvoiceId'].$_POST['_newItemName'].'.png';
		$formData = 'https://localhost/base/delivery.php?search='.$_POST['_newInvoiceId'];
		QRcode::png($formData, $codesDir.$codeFile); 
	} else {
		header('location:./');
	}

	//DEFAULT RESPONSES
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	/**
	 * SESSION MANAGEMENT - ALLOWS SUPER ADMIN / ADMIN / SALES TO ADDNEWORDER
	 * ELSE REDIRECTS TO INDEX.PHP
	 * FINDS THEIR SESSION TIME AS WELL USING SESSION VARIABLES
	 */	
	if (!session_id()) session_start();
	//USERS WITH ACCESS
	if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) )
	{
		date_default_timezone_set('Asia/Dubai'); 
		header("Location:index.php");
		app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt");
	}
	else{
		if(time()-$_SESSION['expire'] > 365*24*60*60)
		{
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Session is expired, User '".$_SESSION['userName']."' is logged out.");
			session_destroy();
		}
		else{
			$_SESSION['expire'] - time();
			$pendingSessionTime = $_SESSION['expire'] - time();
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : User '".$_SESSION['userName']."'s Session would be expired in '".$pendingSessionTime."'");
		}
	}

	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */	
	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = '../log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}

	/**
	 * GETS CURRENT TIME AND RETURNS AS LOCAL TIME
	 */
	function curdate() {
		date_default_timezone_set('Asia/Dubai');
		return date('Y-m-d');
	}

	/**
	 * RETREIVES USER ENTRY FROM ADDNEWORDER.PHP AND STORES IT 
	 * IN LOCAL VARIABLES
	 */
	if (isset($_POST['_newInvoiceId']) || isset($_POST['_newDeliveryDate']) || isset($_POST['_newItemName']) || isset($_POST['_newItemColor']) || isset($_POST['_newItemSize']) || isset($_POST['_newItemFrom']) || isset($_POST['_newDeliveryLocation']) || isset($_POST['_newStatus']) || isset($_POST['_newQuantity']) || isset($_POST['_newOrderNote']) || isset($_FILES['_newDeliveryNoteFile']) || isset($_POST['_newSalesConsultant']) || isset($_FILES['_newOrderImage']) || isset($_POST['_newCat_Id']) || isset($_POST['_newPaymentTerms']) || isset($_POST['_newCondition']) || isset($_FILES['_newSwatchImage'])){
		$invoice = $_POST['_newInvoiceId'];
		$dd = $_POST['_newDeliveryDate'];
		$itemname = $_POST['_newItemName'];
		$color = $_POST['_newItemColor'];
		$size = $_POST['_newItemSize'];
		$from = $_POST['_newItemFrom'];
		$deliverylocation = $_POST['_newDeliveryLocation'];
		$status = $_POST['_newStatus'];
		$quantity = $_POST['_newQuantity'];
		$ordernote = $_POST['_newOrderNote'];
		$salesconsultant = $_POST['_newSalesConsultant'];
		$cat_id = $_POST['_newCat_Id'];
		$paymentTerms = $_POST['_newPaymentTerms'];
		$condition = $_POST['_newCondition'];

		//DELIVERY DATE CONVERT
		$deliveryDate = date('Y-m-d',strtotime($dd));

		//GET CURRENT DATE AND USER
		$insertDate=curdate();
		$userid = $_SESSION['userName'];

		$deliveryDateToSec = strtotime($deliveryDate);
		$insertDateToSec = strtotime($insertDate);
		$timeDiff = abs($deliveryDateToSec - $insertDateToSec);
		$dateAvailability = $timeDiff/86400;
		$dateAvailability = intval($dateAvailability);

		/**
		 * SINGLE / MULTIPLE IMAGE UPLOAD
		 */
		$imageName = '';
		$image = '';
		foreach($_FILES['_newOrderImage']['tmp_name'] as $key => $_newOrderImage) 
		{
			if(!empty($_FILES['_newOrderImage']['tmp_name'][$key]))
			{
				$imageTmpName = $_FILES['_newOrderImage']['tmp_name'][$key];
				$name = $_FILES['_newOrderImage']['name'][$key];
				//IMAGE NAME WILL BE PREFIXED WITH RANDOM NUMBERS
				$random = rand(000,999);
				$random = str_pad($random, 3, '0', STR_PAD_LEFT);
				$name = $random.$name;
				//MULTIPLE IMAGE NAMES WILL BE SAVED WITH COMMAS
				$image=$image.$name.",";
				//DELETE LAST COMMA
				$imageName = substr(trim($image), 0, -1);
				$result = move_uploaded_file($imageTmpName,$image_upload_dir.$name);
			}
			else{
				$imageName = '';
			}
		}

		/**
		 * SAVE SWATCH IMAGE
		 */
		$swatchName = '';
		$swatchImage = '';
		if(!empty($_FILES['_newSwatchImage']['tmp_name']))
		{
			$swatchTmpName = $_FILES['_newSwatchImage']['tmp_name'];
			$swatchName = $_FILES['_newSwatchImage']['name'];
			$swatchName = $invoice.' - '.$itemname.' - '.$swatchName;
			$result = move_uploaded_file($swatchTmpName,$swatch_upload_dir.$swatchName);
		}
		else{
			$swatchName = '';
		}

		/**
		 * DELIVERY NOTE UPLOAD - PDF
		 */
		$_pdfDN = '';
		if(!empty($_FILES['_newDeliveryNoteFile']['name'])){
			$dnTMP = $_FILES['_newDeliveryNoteFile']['tmp_name'];
			$_pdfDN = $_FILES['_newDeliveryNoteFile']['name'];
			$result = move_uploaded_file($dnTMP,$pdf_upload_dir.$_pdfDN);
		}
		else{
			$_pdfDN = 'No Note Attached';
		}
		
		/**
		 * SAVES ALL USER ENTRY ALONG WITH ENTRY CREATED USER
		 * AND GENERATED QR CODE
		 */
		try{
			if(!empty ($imageName)){
				$insert = $conn->query("INSERT INTO product(
					insertDate,
					branchId,
					city,
					invoiceId,
					deliveryNote,
					pname,
					pimage,
					size,
					color,
					quantity,
					pstatus,
					ordernote,
					salesperson,
					cat_id,
					productlink,
					dateAvailability,
					createdBy,
					qrcode)
				VALUES 
				('".$insertDate."',
				'".$from."',
				'".$deliverylocation."',
				'".$invoice."',
				'".$_pdfDN."',
				'".$itemname."',
				'".$imageName."',
				'".$size."',
				'".$color."',
				'".$quantity."',
				'".$status."',
				'".$ordernote."',
				'".$salesconsultant."',
				'".$cat_id."',
				'".$deliveryDate."',
				'".$dateAvailability."',
				'".$userid."',
				'".$codeFile."')");
				if($insert){
					$last_id = $conn->insert_id;
					$salesQuery = $conn->query("INSERT INTO sales_agreement (
						order_id,
						del_date,
						swatch,
						payment_term,
						order_condition,
						sales_consultant
					) VALUES (
						'".$last_id."',
						'".$deliveryDate."',
						'".$swatchName."',
						'".$paymentTerms."',
						'".$condition."',
						'".$salesconsultant."'
					)");
					if($salesQuery){
						$response['status'] = 1;
						$response['message'] = 'Form data submitted successfully!';
						$response['success'] = 'true';
					}
				}
			}
		}catch(Exception $error){
			echo 'RZ|DAUNTE EXCEPTION: ',  $error->getMessage(), "\n";
		}

	}
	echo json_encode($response);
?>
