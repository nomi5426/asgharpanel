<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: DATABASE MANAGEMENT
	* 
	* VARIABLES
	* @PARAM	{STRING}	HOST								//DB HOST
	* @PARAM	{STRING}	USERNAME							//HOST USERNAME
	* @PARAM	{STRING}	PASSWORD							//HOST PASSWORD
	* @PARAM	{STRING}	DBNAME								//DATABASE NAME
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	*
	/********************************************************************************/

	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */
	// function app_log($message){
	// 	date_default_timezone_set('Asia/Dubai');
	// 	$logfile = 'log/log_'.date('d-M-Y').'.log';
	// 	file_put_contents($logfile, $message . "\n", FILE_APPEND);
	// }

	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "asgharpanel";
	//MAKES THE CONNECTION
	$conn = mysqli_connect($host, $username, $password, $dbname);
	if (!$conn) {
		// app_log("'".date('d-m-Y H:i:s')."' : DATABASE connection hasn't been made. Please check DB Config;");
		die("Connection failed: " . mysqli_connect_error());
	}

?>