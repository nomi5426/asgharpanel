
<?php
include "../base/db.php";
$image_upload_dir = '../uploads/';
$pdf_upload_dir = '../pdfUploads/';

	//SESSION MANAGEMENT
	if (!session_id()) session_start();
	//USERS WITH ACCESS
	if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) && (!isset($_SESSION['_factoryLogin'])) )
	{
		date_default_timezone_set('Asia/Dubai'); 
		header("Location:index.php");
		app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt Admin User");
	}
	else{
		if(time()-$_SESSION['expire'] > 365*24*60*60){
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Session is expired, User '".$_SESSION['userName']."' is logged out.");
			session_destroy();
		}
		else{
			$_SESSION['expire'] - time();
			$pendingSessionTime = $_SESSION['expire'] - time();
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : User '".$_SESSION['userName']."'s Session would be expired in '".$pendingSessionTime."'");
		}
	}
	//LOG MANAGEMENT
	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = '../log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	} 
	//CURRENT TIME
	function curdate() {
		// gets current timestamp
		date_default_timezone_set('Asia/Dubai');
		return date('Y-m-d');
	}
	//SELECT INVOICE ID FOR STATUS
	if(isset($_POST['selectedstat'])){
		$_output='';
		$filterNonMaterial='No';
		$sql = "SELECT * FROM product WHERE pstatus='".$_POST['selectedstat']."'";
		$sql .=	"AND material ='No' ORDER BY invoiceId";
		$query=mysqli_query($conn,$sql);
		$_output .='<option value="" disabled selected>Select Invoice ID</option>';
		while($row = mysqli_fetch_array($query)){
			$_output .='<option data-id="'.$row['id'].'" value="'.$row["invoiceId"].'">'.$row["invoiceId"]." - ".$row["pname"].' </option>';
		}
		echo $_output;
	}
	//GET THE ORDER
	if(isset($_POST['id'])){
		$return_arr = array();
		$sql="SELECT * FROM product where id='".$_POST['id']."'";
		$query=mysqli_query($conn,$sql);
		$rows = array();
		while($row = mysqli_fetch_array($query)){
			$rows[] = $row;
		}
		$json = json_encode($rows);
		echo $json;
	}
?>