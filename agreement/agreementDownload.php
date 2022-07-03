<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: GENERATING PDF DELIVERY NOTE FOR READING
	* 
	* VARIABLES
	* @PARAM	{INT}	    ID								    //DB CONNECT VARIABLE
	* @PARAM	{STRING}	SQL								    //QUERY
	* @PARAM	{STRING}	FILE								//FILE NAME
	* @PARAM	{STRING}	FILEPATH							//FILE PATH AND FILE NAME
    * @PARAM	{STRING}	RESULT								//INJECT QUERY
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	PDFUPLOAD							//PDFDIRECTORY
    *
	/********************************************************************************/

    //INCLUDE DIRECTORIES
    include "../base/db.php";
    $pdfUpload = "../pdfUploads/";
    $salesAgreementUpload = "../salesAgreementUpload/";

    /**
     * PURPOSE: GETS ORDER ID AND FINDS ITS DELIVERY NOTE FILE NAME
     * ONCE THE FILE NAME IS FOUND IT PRINTS THE NOTE AS HOW ITS REQUESTED
     */
    if (isset($_GET['order_id'])) {
        $id = $_GET['order_id'];
        // fetch file to download from database
        $sql = $conn->query("SELECT * FROM sales_agreement WHERE order_id='$id'");
        $file = mysqli_fetch_assoc($sql);
        $filepath = $salesAgreementUpload . $file['sales_agreement_path'];
        //IF REQUIRED FILE DOESN'T EXIST
        if (!file_exists($filepath)) {
            echo "<script type='text/javascript'>alert('No File Exists')</script>";
        }
        //IF IT EXISTS
        else{
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($salesAgreementUpload . $file['sales_agreement_path']));
            //ob_clean();
            //flush();  
            readfile($filepath);
            exit;
        }
    }

?>