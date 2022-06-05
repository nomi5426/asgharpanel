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

    /**
     * PURPOSE: GETS ORDER ID AND FINDS ITS DELIVERY NOTE FILE NAME
     * ONCE THE FILE NAME IS FOUND IT PRINTS THE NOTE AS HOW ITS REQUESTED
     */
    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];
        // fetch file to download from database
        $sql = "SELECT * FROM product WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);
        $filepath = $pdfUpload . $file['deliveryNote'];
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
            header('Content-Length: ' . filesize($pdfUpload . $file['deliveryNote']));
            //ob_clean();
            //flush();  
            readfile($filepath);
            exit;
        }
    }

?>