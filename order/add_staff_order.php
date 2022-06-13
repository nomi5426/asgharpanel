<?php
	include "../base/db.php";
	
	$response['index'] = 0;

	try{
		if(isset($_POST['order_id']) && isset($_POST['staff_id'])){
			$order_id = $_POST['order_id'];
			$staff_id = $_POST['staff_id'];
	
			$_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE order_id = '$order_id'");
	
			if(mysqli_num_rows($_staffAssociate)!=0){
				$response['index'] = 1;
			}
			else{
				$insertStaff = $conn->query("INSERT INTO order_staff (order_id, staff_id) VALUES ('".$order_id."', '".$staff_id."')");
				if($insertStaff){
					$updateStatus = $conn->query("UPDATE product SET pstatus = 'Ready' WHERE id =".$order_id);
					if($updateStatus){
						$response['index'] = 2;
					}
				}else{
					$response['index'] = 0;
				}
			}
		}else{
			$response['index'] = 0;
		}
	}catch(Exception $error){
		echo 'RZDAUNTE exception: ',  $error->getMessage(), "\n";
	}
	echo json_encode($response);
?>