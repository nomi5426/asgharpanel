<?php
include "../base/db.php";
//Current timestamp
function curdate() {
	date_default_timezone_set('Asia/Dubai'); 
	return date('Y-m-d');
}


if(isset($_POST['selectedstat'])){
	$_output='';
	$sql = "SELECT * FROM product WHERE pstatus='".$_POST['selectedstat']."' ORDER BY invoiceId";
	$query=mysqli_query($conn,$sql);
	$_output .='<option value="" disabled selected>Select Invoice ID</option>';
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
	$commentAdded = "Comment has been added succesfully";
	if($result){
		echo "<script type='text/javascript'>alert('$commentAdded')</script>";
	}
}

// if(isset($_POST['newcomment']))
// {
//   $id=$_POST['id'];
//   $userid=$_SESSION['login'];
//   $userComment = $_POST['userComment'];
//   $currentDate = curdate();
//   $all = $userComment.'-'.$currentDate;
//   $sql = "UPDATE `product` SET `userComment` = '$all' WHERE `id` = '$id'";
//   $run = $conn->query($sql) or die("Error in Entry".$conn->error);
//   if ($run) {
// 	date_default_timezone_set('Asia/Dubai');
// 	app_log("'".date('d-m-Y H:i:s')."' Order ID : '".$id."' has been commented as '".$userComment."' by '".$userid."'");
// 		  header('Location: admin.php');
// 	  }
//}

?>