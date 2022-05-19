<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';

	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	//EDIT CATEGORY - RETREIVES CATEGORY ID AND NAME 
	if(isset($_POST['id']) || isset($_POST['mat_status']) || isset($_POST['mat_lpo_id'])){
		$id = $_POST['id'];
		$materialStatus = $_POST['mat_status'];
		$matLpoId = $_POST['mat_lpo_id'];

		$sql = "SELECT * FROM product WHERE id='".$id."'";
		$query=mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($query);

		$materialStatus = $row['pstatus'];
		$materialAvilabilityQuery="";
		//IF THE STATUS IS UNKNOWN
		if($materialStatus !== "Yes"){
			$materialAvilabilityQuery = "update product set material = 'Yes' where id=".$id;
		}
		$result = mysqli_query($conn,$materialAvilabilityQuery);
		if($result){
			$lpoQuery = "INSERT INTO order_lpo (order_id, lpo_id) VALUES ('".$id."','".$matLpoId."')";
		}
		$lpoResult = mysqli_query($conn,$lpoQuery);
		if($lpoResult){
			$response['status'] = 1;
			$response['message'] = 'Lpo and Material are updated successfully';
			$response['success'] = 'true';
		}
	}
header('Content-type: application/json');
echo json_encode($response);

