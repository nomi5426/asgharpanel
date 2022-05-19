<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';


	if (isset($_POST['staff_name']) || isset($_POST['staff_department']) ){
		$_staffName = $_POST['staff_name'];
		$_staffCategory = $_POST['staff_department'];

		$uploadStatus = 1; 
		
		if($uploadStatus = 1){
			// Insert form data in the database 
			$insert = $conn->query("INSERT INTO staff (staff_name,staff_department) VALUES ('".$_staffName."','".$_staffCategory."')");
			if($insert){ 
				$response['status'] = 1;
				$response['message'] = 'Form data submitted successfully!';
				$response['success'] = 'true';
			}
		}
	}
	echo json_encode($response);
?>
