<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: DESTROY SESSION AND GET THE USER LOGGED OUT
	* 
	* VARIABLES
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/********************************************************************************/
	
    //INCLUDE DIRECTORIES
	include "../base/db.php";

	//KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
    //SUPERADMIN
    if(isset($_SESSION['_superAdminLogin'])){
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Super Admin User '".$_SESSION['_superAdminLogin']."' is logged out. ");
    }
    //ADMIN
    else if(isset($_SESSION['_adminLogin'])){
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Admin User '".$_SESSION['_adminLogin']."' is logged out. ");
    }
    //SALES
    else if(isset($_SESSION['_salesLogin'])){
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Sales User '".$_SESSION['_salesLogin']."' is logged out. ");
    }
    //FACTORY
    else if(isset($_SESSION['_factoryLogin'])){
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Factory User '".$_SESSION['_factoryLogin']."' is logged out. ");
    }
    //STAFF
    else if(isset($_SESSION['_staffLogin'])){
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Staff User '".$_SESSION['_staffLogin']."' is logged out. ");
    }
    session_destroy();
    header("Location: ../index.php");
    die();

    /**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */
	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = 'log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}
    
?>