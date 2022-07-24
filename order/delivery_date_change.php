<?php

	include "../base/db.php";

	if (!session_id()) session_start();

	$response['index'] = 0;

	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */
	function app_log($message){
        $logPath  = "../log/log_";
		date_default_timezone_set('Asia/Dubai');
		$logfile = $logPath.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}

    //GET USER DETAIL
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
    }

	if(isset($_POST['id']) || isset($_POST['dd_new_date'])){
		$id = $_POST['id'];
		$ddDate = $_POST['dd_new_date'];

		$deliveryDate = date('Y-m-d',strtotime($ddDate));
		$result=$conn->query("UPDATE product SET productlink = '$deliveryDate' WHERE id = '$id'");
		if($result){
			$response['index'] = 1;
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : New Date (".$deliveryDate.") has been changed for productId : '".$id."' avalability is confirmed by '".$username."'");
		}
	}

	echo json_encode($response);
?>