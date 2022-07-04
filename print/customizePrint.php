<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: CUSTOMIZE PRINTING CLASS TO GENERATE JOB ORDERS
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
        $logoURL = "pdflogo.png";
        $pdf=new FPDF();
        while($rows = mysqli_fetch_array($result))
        {
            //$pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->Image($logoURL,11,5);
            $pdf->SetFont('Arial','B',20);
            $pdf->Cell(0,5,'SALES AGREEMENT',0,0,'R');
            $pdf->Ln();
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(118,35,'Prime Business Centre - Office #1005 - B',0,0,'L');
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,22,'INVOICE ID',0,0,'R');
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(0,22,$rows['invoiceId'],0,0,'R');
            $pdf->Ln(40);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(118,-35,'Jumeira Village Circle, Dubai - UAE',0,0,'L');
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,-35,'DELIVERY DATE',0,0,'R');
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(0,-35,$rows['productlink'],0,0,'R');
            $pdf->Ln(-10);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(132,5,'ITEM & DESCRIPTION',0,0,'L');
            $pdf->Ln(10);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(151,0,$rows['pname'],0,0,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,0,'SALES :',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(20,0,$rows['salesperson'],0,0,'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(28,0,'COLOR : ',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(127,0,$rows['color'],0,0,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,0,'CITY :',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(20,0,$rows['city'],0,0,'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(28,0,'SIZE :',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(127,0,$rows['size'],0,0,'L');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(20,0,'QTY :',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(20,0,$rows['quantity'],0,0,'L');
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(28,0,'ORDER NOTE : ',0,0,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,0,$rows['ordernote'],0,0,'L');
            $pdf->Ln(8);

            //GET IMAGE
            if($rows['pimage']!==''){ 
            if(strpos($upload_dir.$rows['pimage'],',') !== false){
                $arr = explode(',', $rows['pimage']);
                $image = $arr[0];
            }
            else{
                $image = $rows['pimage'];
            }
            }
            else{
            $noImage = 'No Image.jpg';
            $image = $noImage;
            }
            $image = $upload_dir.$image;
            
            $pdf->Cell( 170, 40, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 188,150), 0, 0, 'L', false );
            $pdf->Ln(155);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(25,8,'Framing ',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'W/Quality ',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'Foam Dens ',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'Size CHK',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'B/W PROD',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Ln(10);
            $pdf->Cell(25,8,'Leg Den',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'Leg COL ',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'COL Wood',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'COL FAB',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
            $pdf->Cell(25,8,'AFTER PROD',0,0,'C');
            $pdf->Cell(10,8,'',1,0,'L');
        }
        $pdf->SetY(-1);
        $pdf->SetFont('Arial','',12);
        $pdf->Output();
    }
?>