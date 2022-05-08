<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';
	
	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';


	if (isset($_POST['category_name']) || isset($_POST['master_cat']) ){
		$_catName = $_POST['category_name'];
		$_masterCat = $_POST['master_cat'];

		$uploadStatus = 1; 
		
		if($uploadStatus = 1){
			// Insert form data in the database 
			$insert = $conn->query("INSERT INTO category (category_name,master_cat) VALUES ('".$_catName."','".$_masterCat."')");
			if($insert){ 
				$response['status'] = 1;
				$response['message'] = 'Form data submitted successfully!';
				$response['success'] = 'true';
			}
		}
	}
	echo json_encode($response);
?>
