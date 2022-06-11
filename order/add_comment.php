<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: COMMENT ADDING DB MANAGMENT / RELATED FILE - 
	*			PUSHED FROM AND GOES TO ADDNEWCOMMENT.PHP AND STATUSMODAL.PHP
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	* @PARAM	{STRING}	RESPONSE							//DEFAULT RESPONSE
	* @PARAM	{STRING}	SQL									//SQL STATEMENT
	* @PARAM	{STRING}	QUERY								//SQLI PARAM TO IMPLEMENT QUERY
	* @PARAM	{STRING}	_OUTPUT								//RETURN DATA TO SOURCE DIRECTORY
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/********************************************************************************/

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	
	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */	function curdate() {
		date_default_timezone_set('Asia/Dubai'); 
		return date('Y-m-d H:i');
	}

	/**
	 * @PARAM RESPONSE -RETURN VALUE
	 */
	$response['index'] = 0;

	/**
	 * RECEIVES SELECTEDSTAT FROM ADDNEWCOMMENT.PHP 
	 * AND RETURNS INVOICE ID AND ITEM NAME
	 */
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

	/**
	 * RECEIVES ID FROM ADDNEWCOMMENT.PHP 
	 * AND STATUSCHANGEMODAL.PHP FOR RETURNING
	 * EXISTING USERCOMMENT
	 */
	if(isset($_POST['id'])){
		$_output='';
		$sql="SELECT * FROM product where id='".$_POST['id']."'";
		$query=mysqli_query($conn,$sql);
		while($row = mysqli_fetch_array($query)){
			$_output .=$row['userComment'];
		}
		echo $_output;
	}

	/**
	 * RECEIVES OID AND NEW COMMENT FROM 
	 * ADDNEWCOMMENT.PHP AND STATUSCHANGEMODAL.PHP TO
	 * SAVE NEW USERCOMMENT AND RETURNS @PARAM RESPONSE = 1 AS SUCCESS
	 */
	if(isset($_POST['oid']) || isset($_POST['newcomment'])){
		$newcomment = $_POST['newcomment'];
		$id = $_POST['oid'];
		// echo 'Received record is: ' . $newcomment.$id;
		$currentDate = curdate();
		$all = $newcomment.' - '.$currentDate."</br>";
		$result = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all') WHERE id = '$id'");
		if($result){
			$response['index'] = 1;
		}
	}

	echo json_encode ($response);

?>
