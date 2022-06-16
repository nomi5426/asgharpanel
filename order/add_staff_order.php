<?php
	include "../base/db.php";
	
	$response['index'] = 0;

	try{
		$ordId=intval($_POST['order_id']);
		$findOrder = $conn->query("SELECT * FROM product WHERE id = ".$ordId);
		while($row=mysqli_fetch_array($findOrder)){
			$id=$row['id'];
			$itemStat = $row['pstatus'];
		}
		if($itemStat == 'In Production'){
			if(isset($_POST['order_id']) && isset($_POST['staff_id'])){
				$order_id = $_POST['order_id'];
				$staff_id = $_POST['staff_id'];
		
				$_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE order_id = '$order_id'");
		
				if(mysqli_num_rows($_staffAssociate)!=0){
					$response['index'] = 1;
				}
				else{
					$insertProdStaff = $conn->query("INSERT INTO order_staff (order_id, staff_id,del_staff_id) VALUES ('".$order_id."', '".$staff_id."',17)");
					if($insertProdStaff){
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
		}else if($itemStat == 'Ready'){
			if(isset($_POST['order_id']) && isset($_POST['staff_id'])){
				$order_id = $_POST['order_id'];
				$staff_id = $_POST['staff_id'];

				$delStaffAssoociate = $conn->query("SELECT * FROM order_staff WHERE order_id = ".$order_id);
				if(mysqli_num_rows($delStaffAssoociate) != 0){
					$DelStaff = $conn->query("UPDATE order_staff SET del_staff_id = $staff_id WHERE order_id = ".$order_id);
				}else{
					$DelStaff = $conn->query("INSERT INTO order_staff (order_id, staff_id, del_staff_id) 
					VALUES ('".$order_id."', 17, '".$staff_id."')");
				}
				if($DelStaff){
					$updateStatus = $conn->query("UPDATE product SET pstatus = 'Out for Delivery' WHERE id =".$order_id);
					if($updateStatus){
						$response['index'] = 2;
					}
				}else{
					$response['index'] = 0;
				}
			}else{
				$response['index'] = 0;
			}
		}
	}catch(Exception $error){
		echo 'RZDAUNTE exception: ',  $error->getMessage(), "\n";
	}
	echo json_encode($response);
?>