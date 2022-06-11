<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: GENERATE QR CODE OF PENDING ORDERS FOR FACTORY PURPOSES
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/********************************************************************************/

	//INCLUDE DIRECTORIES
    include "fpdf.php";
    include "../base/db.php";
    $qr_dir = '../qrcodes/';
    $upload_dir = '../uploads/';
    
    /**
     * GETS THE INVOICE JOB ORDER WITH ID AND BUILD USING FPDF CLASS
     */
    if(!isset($_GET['id'])){
    echo 'PAGE NOT FOUND!';
    }
    else if(($_GET['action'] == 'select') && isset($_GET['id'])) 
    {
        $id = $_GET['id'];
        $sql = "Select * FROM product WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $logoURL = "../qrprint/pdflogo.png";
        
        $pdf = new FPDF('P','mm',array(100,180));
        $pdf->SetAutoPageBreak(TRUE, 0);
        
        while($rows = mysqli_fetch_array($result))
        {
            $pdf->AddPage();
            $pdf->Image($logoURL,5,15);
            $pdf->SetFont('Arial','B',30);
            $image = $rows['qrcode'];
            $image = $qr_dir.$image;
            $pdf->Image($image,32,6);
            $pdf->SetFont('Arial','B',15);
            //GET IMAGE
            if($rows['pimage']!==''){ 
                if(strpos($upload_dir.$rows['pimage'],',') !== false){
                    $arr = explode(',', $rows['pimage']);
                    $prImage = $arr[0];
                }
                else{
                    $prImage = $rows['pimage'];
                }
            }
            else{
                $noImage = 'No Image.jpg';
                $prImage = $noImage;
            }
            $prImage = $upload_dir.$prImage;
            $pdf->Image($prImage, 65, 9, 27, 27);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(15,45,'SINCE 1977',0,0,'C');
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,50,'--------------------------------------------------------------------',0,0,'C');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(30,50,'Item & Description',0,0,'C');
            $pdf->Ln(30);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(80,5,$rows['pname'],0);
            $pdf->Ln(0);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(1,10,'Size',0,0,'C');
            $pdf->Ln(10);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(80,5,$rows['size'],0);
            $pdf->Ln(0);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(10,10,'Quantity',0,0,'C');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(-2,6,$rows['quantity'],0,0,'L');
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(5,10,'Color',0,0,'C');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(80,5,$rows['color'],0);
            $pdf->Ln(0);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(5,10,'Notes',0,0,'C');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(0,5,$rows['ordernote'],1);
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',40);
            $pdf->Cell(0,10,$rows['invoiceId'],0,0,'C');
        }
        $pdf->Output();
    }

?>