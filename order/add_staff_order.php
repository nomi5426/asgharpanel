<?php

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	
	//KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
	if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_factoryLogin'])) && (!isset($_SESSION['_deliveryLogin']))){
		header('Location:../index.php');
	}

	if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= $conn->query("SELECT * FROM user WHERE username='".$username."'");
        while($row = mysqli_fetch_assoc($userDetail)) {
            $_firstName = $row['firstname'];
            $_userRole = $row['userrole'];
			$_userName = $row['username'];
        }
    }

	function app_log($message){
        $logPath  = "../log/log_";
		date_default_timezone_set('Asia/Dubai');
		$logfile = $logPath.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}

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

				foreach($staff_id as $staffId){
					$insertProdStaff = $conn->query("INSERT INTO order_staff_production (order_id, staff_id,active_status) VALUES ('".$order_id."', '".$staffId."',1)");
					date_default_timezone_set('Asia/Dubai');
					app_log("'".date('d-m-Y H:i:s')."' : Production Staff for Order ID '".$order_id."' 
					as Staff ID : '".$staff_id."' and Active Status : 1 
					by User : '".$_userName."' ROOT: add_staff_order.php");
				}
				if($insertProdStaff){
					$updateStatus = $conn->query("UPDATE product SET pstatus = 'Ready' WHERE id = $order_id");
					if($updateStatus){
						$response['index'] = 2;
						date_default_timezone_set('Asia/Dubai');
						app_log("'".date('d-m-Y H:i:s')."' : Order Status of order ID : '".$order_id."' 
						is changed (Ready) after adding Production staff 
						by User : '".$_userName."' ROOT: add_staff_order.php");
					}
				}
			}else{
				$response['index'] = 0;
			}
		}else if($itemStat == 'Ready'){
			if(isset($_POST['order_id']) && isset($_POST['staff_id'])){
				$order_id = $_POST['order_id'];
				$del_staff_id = $_POST['staff_id'];

				foreach($del_staff_id as $delStaffId){
					$insertDelStaff = $conn->query("INSERT INTO order_staff_delivery (order_id, del_staff_id,active_status) VALUES ('".$order_id."', '".$delStaffId."',1)");
					date_default_timezone_set('Asia/Dubai');
					app_log("'".date('d-m-Y H:i:s')."' : Delivery Staff for Order ID '".$order_id."' 
					as Staff ID : '".$staff_id."' and Active Status : 1 
					by User : '".$_userName."' ROOT: add_staff_order.php");
				}
				if($insertDelStaff){
					$updateStatus = $conn->query("UPDATE product SET pstatus = 'Out for Delivery' WHERE id = $order_id");
					if($updateStatus){
						$response['index'] = 2;
						date_default_timezone_set('Asia/Dubai');
						app_log("'".date('d-m-Y H:i:s')."' : Order Status of order ID : '".$order_id."' 
						is changed (Out for Delivery) after adding Delivery Staff 
						by User : '".$_userName."' ROOT: add_staff_order.php");
					}
				}
			}else{
				$response['index'] = 0;
			}
		}

	}catch(Exception $error){
		echo 'RZDAUNTE exception: ',  $error->getMessage(), "\n";
		date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' 
        ERROR TO BE CHECKED. ERROR: '".$errMessage ->getMessage()."' 
        - FAILED - by User : '".$_userName."' ROOT: add_order_staff.php");
	}
	echo json_encode($response);
?>