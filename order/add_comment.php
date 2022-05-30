<?php
	include "../base/db.php";
	//CURRENT TIMESTAMP
	function curdate() {
		date_default_timezone_set('Asia/Dubai'); 
		return date('Y-m-d');
	}

	/**
	 * PUSHED FROM AND GOES TO ADDNEWCOMMENT.PHP AND STATUSMODAL.PHP
	 * 
	 */

	$response['index'] = 0;

	if(isset($_POST['selectedstat'])){
		$_output='';
		$sql = "SELECT * FROM product WHERE pstatus='".$_POST['selectedstat']."' ORDER BY invoiceId";
		$query=mysqli_query($conn,$sql);
		$_output .='<option value="Select Invoice ID" selected>Select Invoice ID</option>';
		while($row = mysqli_fetch_array($query)){
			$_output .='<option data-id="'.$row["id"].'" value="'.$row["invoiceId"].'">'.$row["invoiceId"]." - ".$row["pname"].' </option>';
		}
		echo $_output;
	}


	if(isset($_POST['id'])){
		$_output='';
		$sql="SELECT * FROM product where id='".$_POST['id']."'";
		$query=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_array($query)){
			$_output .=$row['userComment'];
		}
		echo $_output;
	}

	if(isset($_POST['oid']) || isset($_POST['newcomment'])){
		$newcomment = $_POST['newcomment'];
		$id = $_POST['oid'];
		// echo 'Received record is: ' . $newcomment.$id;
		$currentDate = curdate();
		$all = $newcomment.' - '.$currentDate;
		$sql = "UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all') WHERE id = '$id'";
		$result = mysqli_query($conn,$sql);
		if($result){
			$response['index'] = 1;
		}
	}
	json_encode ($response);
?>