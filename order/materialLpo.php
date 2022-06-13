<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';

	$response['status'] = 0;

	if(isset($_POST['mat_id'])){
		$_output='';
		$sql="SELECT * FROM order_lpo where order_id = ".$_POST['mat_id'];
		$query=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_array($query)){
			$_output .=$row['lpo_id'];
		}
		echo $_output;
	}

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
			$materialAvilabilityQuery = "UPDATE product SET material = 'Yes', pstatus = 'In Production' WHERE id=".$id;
		}
		$result = mysqli_query($conn,$materialAvilabilityQuery);
		if($result){
			$lpoQuery = "INSERT INTO order_lpo (order_id, lpo_id) VALUES ('".$id."','".$matLpoId."')";
		}
		$lpoResult = mysqli_query($conn,$lpoQuery);
		if($lpoResult){
			$response['status'] = 1;
		}
	}
// header('Content-type: application/json');
echo json_encode($response);

