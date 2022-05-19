<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';

	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

	//EDIT CATEGORY - RETREIVES STAFF ID AND NAME 
	if(isset($_POST['id']) || isset($_POST['staff_name'])){
		$staffName = $_POST['staff_name'];
		$id = $_POST['id'];
		$uploadStatus = 1;

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
			$response['message'] = 'STAFF EXISTS WITH ORDER';
			$response['success'] = 'true';
		}
		else{
			if($staffName != $_dbStaff_name){
				$_update = $conn->query("UPDATE staff SET staff_name = '{$staffName}' WHERE id = ".$id);
				if($_update){
					$response['status'] = 1;
					$response['message'] = 'Staff submitted successfully!';
					$response['success'] = 'true';
				}
			}else{
				$response['status'] = 2;
				$response['message'] = 'NO CHANGE';
				$response['success'] = 'true';
			}
		}
	}
	header('Content-type: application/json');
	echo json_encode($response);
?>

