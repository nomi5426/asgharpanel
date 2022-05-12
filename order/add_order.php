<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	
	//DEFAULT RESPONSES
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	//SESSION MANAGEMENT
	if (!session_id()) session_start();
	//USERS WITH ACCESS
	if( (!isset($_SESSION['superadminlogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) )
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
	//LOG MANAGEMENT
	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = '../log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	} 
	//CURRENT TIME
	function curdate() {
		// gets current timestamp
		date_default_timezone_set('Asia/Dubai');
		return date('Y-m-d');
	}

	//RETRIEVES RECORD FROM ADD ORDER MODAL
	// if (isset($_POST['_newInvoiceId']) || isset($_POST['_newDeliveryDate']) || isset($_POST['_newItemName']) || isset($_POST['_newItemColor']) || isset($_POST['_newItemSize']) || isset($_POST['_newItemFrom']) || isset($_POST['_newDeliveryLocation']) || isset($_POST['_newStatus']) || isset($_POST['_newQuantity']) || isset($_POST['_newOrderNote']) || isset($_FILES['_newDeliveryNoteFile']) || isset($_POST['_newSalesConsultant']) || isset($_FILES['_newOrderImage']) || isset($_POST['_newCat_Id'])){
	if (isset($_POST['_newInvoiceId']) || isset($_POST['_newDeliveryDate']) || isset($_POST['_newItemName']) || isset($_POST['_newItemColor']) || isset($_POST['_newItemSize']) || isset($_POST['_newItemFrom']) || isset($_POST['_newDeliveryLocation']) || isset($_POST['_newStatus']) || isset($_POST['_newQuantity']) || isset($_POST['_newOrderNote']) || isset($_FILES['_newDeliveryNoteFile']) || isset($_POST['_newSalesConsultant']) || isset($_FILES['_newOrderImage']) || isset($_POST['_newCat_Id'])){
		$invoice = $_POST['_newInvoiceId'];
		$deliveryDate = $_POST['_newDeliveryDate'];
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

		//GET CURRENT DATE AND USER
		$insertDate=curdate();
		$userid = $_SESSION['userName'];

		$deliveryDateToSec = strtotime($deliveryDate);
		$insertDateToSec = strtotime($insertDate);
		$timeDiff = abs($deliveryDateToSec - $insertDateToSec);
		$dateAvailability = $timeDiff/86400;
		$dateAvailability = intval($dateAvailability);

		////IMAGE UPLOAD
		// $uploadStatus = 1;
		$imageName = '';
		$image = '';
		foreach($_FILES['_newOrderImage']['tmp_name'] as $key => $_newOrderImage) 
		{
			if(!empty($_FILES['_newOrderImage']['tmp_name'][$key]))
			{
				$imageTmpName = $_FILES['_newOrderImage']['tmp_name'][$key];
				$name = $_FILES['_newOrderImage']['name'][$key];

				//Image name prefexified with a random number
				$random = rand(000,999);
				$random = str_pad($random, 3, '0', STR_PAD_LEFT);
				$name = $random.$name;

				//Image name will be saved with comma
				$image=$image.$name.",";
				//Delete Last Comma of the Image
				$imageName = substr(trim($image), 0, -1);

				$result = move_uploaded_file($imageTmpName,$image_upload_dir.$name);
			}
			else{
				$imageName = '';
			}
		}

		//PDF UPLOAD
		$_pdfDN = '';
		if(!empty($_FILES['_newDeliveryNoteFile']['name'])){
			$dnTMP = $_FILES['_newDeliveryNoteFile']['tmp_name'];
			$_pdfDN = $_FILES['_newDeliveryNoteFile']['name'];
			$result = move_uploaded_file($dnTMP,$pdf_upload_dir.$_pdfDN);
		}
		else{
			$_pdfDN = 'No Note Attached';
		}
		
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
				createdBy)
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
			'".$userid."')");
		}
		if ($insert) 
		{
			$response['status'] = 1;
			$response['message'] = 'Form data submitted successfully!';
			$response['success'] = 'true';
		}
	}
	echo json_encode($response);
?>
