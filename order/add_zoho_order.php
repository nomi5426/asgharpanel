<?php

	/***************************************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: ZOHO ORDER ADDING DB MANAGMENT / RELATED FILE - 
	*			PUSHED FROM AND GOES TO ZOHO.PHP
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
	* @PARAM	{STRING}	RESPONSE							//RESPONSE SEND TO ZOHO.PHP
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

	/**
	 * SAVES QR WITH ITS FILE NAME IF POST RECEIVES, 
	 * ELSE LOCATE TO INDEX
	 */
	if(isset($_POST) && !empty($_POST)) {
		$codeFile = $_POST['_zInvoiceId'].$_POST['_zItemName'].'.png';
		$formData = 'https://localhost/base/delivery.php?search='.$_POST['_zInvoiceId'];
		QRcode::png($formData, $codesDir.$codeFile); 
	} else {
		header('location:./');
	}

	//DEFAULT RESPONSES
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	/**
	 * SESSION MANAGEMENT - ALLOWS SUPER ADMIN / ADMIN / SALES TO ZOHO
	 * ELSE REDIRECTS TO INDEX.PHP
	 * FINDS THEIR SESSION TIME AS WELL USING SESSION VARIABLES
	 */
	if (!session_id()) session_start();
	if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) )
	{
		date_default_timezone_set('Asia/Dubai'); 
		header("Location:index.php");
		app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt Admin User");
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
	 * RETREIVES USER ENTRY FROM ZOHO.PHP AND STORES IT 
	 * IN LOCAL VARIABLES
	 */	
	if (isset($_POST['_zInvoiceId']) || isset($_POST['_zDeliveryDate']) || isset($_POST['_zItemName']) || isset($_POST['_zItemColor']) || isset($_POST['_zItemSize']) || isset($_POST['_zItemFrom']) || isset($_POST['_zItemTo']) || isset($_POST['_zOrderStatus']) || isset($_POST['_zQuantity']) || isset($_POST['_zOrderNote']) || isset($_FILES['_zDeliveryNoteFile']) || isset($_POST['_zSalesConsultant']) || isset($_FILES['_zOrderImage']) || isset($_POST['_zCategory'])){
		$invoice = $_POST['_zInvoiceId'];
		$dd = $_POST['_zDeliveryDate'];
		$itemname = $_POST['_zItemName'];
		$color = $_POST['_zItemColor'];
		$size = $_POST['_zItemSize'];
		$from = $_POST['_zItemFrom'];
		$deliverylocation = $_POST['_zItemTo'];
		$status = $_POST['_zOrderStatus'];
		$quantity = $_POST['_zQuantity'];
		$ordernote = $_POST['_zOrderNote'];
		$salesconsultant = $_POST['_zSalesConsultant'];
		$cat_id = $_POST['_zCategory'];

		//GET CURRENT DATE AND USER
		$insertDate=curdate();
		$userid = $_SESSION['userName'];

		//DELIVERY DATE CONVERT
		$deliveryDate = date('Y-m-d',strtotime($dd));

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
		foreach($_FILES['_zOrderImage']['tmp_name'] as $key => $_newOrderImage) 
		{
			if(!empty($_FILES['_zOrderImage']['tmp_name'][$key]))
			{
				$imageTmpName = $_FILES['_zOrderImage']['tmp_name'][$key];
				$name = $_FILES['_zOrderImage']['name'][$key];
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
		 * DELIVERY NOTE UPLOAD - PDF
		 */		
		$_pdfDN = '';
		if(!empty($_FILES['_zDeliveryNoteFile']['name'])){
			$dnTMP = $_FILES['_zDeliveryNoteFile']['tmp_name'];
			$_pdfDN = $_FILES['_zDeliveryNoteFile']['name'];
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
					$response['status'] = 1;
					$response['message'] = 'Form data submitted successfully!';
					$response['success'] = 'true';
				}
			}
		}catch(Exception $error){
			echo 'RZ|DAUNTE EXCEPTION: ',  $error->getMessage(), "\n";
		}

	}

	echo json_encode($response);

?>
