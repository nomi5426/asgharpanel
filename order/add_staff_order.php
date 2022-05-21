<?php
	include "../base/db.php";
	
	$response['index'] = 0;

	if(isset($_POST['orderStatus'])){
		$_output='';
		$sql = "SELECT * FROM product WHERE pstatus='".$_POST['orderStatus']."' ORDER BY invoiceId";
		$query=mysqli_query($conn,$sql);
		$_output .='<option value="Select Invoice ID">Select Invoice ID</option>';
		while($row = mysqli_fetch_array($query)){
			$_output .='<option value="'.$row["id"].'">'.$row["invoiceId"]." - ".$row["pname"].' </option>';
		}
		echo $_output;
	}

	try{
		if(isset($_POST['order_id']) || isset($_POST['staff_id'])){
			$order_id = $_POST['order_id'];
			$staff_id = $_POST['staff_id'];
	
			$_staffAssociate = $conn->query("SELECT * FROM `order_staff` WHERE `order_id` = ".$order_id);
	
			if(mysqli_num_rows($_staffAssociate)!=0){
				$response['index'] = 1;
			}
			else{
				$insertStaff = $conn->query("INSERT INTO order_staff (order_id, staff_id) VALUES ('".$order_id."', '".$staff_id."')");
				if($insertStaff){
					$response['index'] = 2;
				}
				$response['index'];
			}
			$response['index'];
		}
	}catch(Exception $error){
		exit;
	}

	echo json_encode($response);
?>