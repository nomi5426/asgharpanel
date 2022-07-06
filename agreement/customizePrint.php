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

    session_start();

    //INCLUDE DIRECTORIES
    include "fpdf.php";
    include "../base/db.php";
    $upload_dir = '../uploads/';
	$swatch_upload_dir = '../swatchUploads/';

    /**
     * GET LOGGED IN USER ID
     */
    $firstName ='';
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= $conn->query("SELECT * FROM user WHERE username='".$username."'");
        while($row = mysqli_fetch_assoc($userDetail)) {
            $firstName = $row['firstname'];
            $userrole = $row['userrole'];
        }
    }
    $userName = strtoupper($firstName);

    /**
     * GETS THE INVOICE JOB ORDER WITH ID AND BUILD USING FPDF CLASS
     */
    if(!isset($_GET['id'])){
        echo 'PAGE NOT FOUND!';
    }
    else if(($_GET['action'] == 'select') && isset($_GET['id'])) 
    {
        $prodId = $_GET['id'];        
        $prodQuery = $conn->query("SELECT * FROM product 
                                LEFT JOIN sales_agreement ON 
                                product.id = sales_agreement.order_id
                                LEFT JOIN customer on
                                product.id = customer.order_id
                                WHERE product.id = '$prodId'");
        $logoURL = "pdflogo.png";
        while($rows = mysqli_fetch_array($prodQuery))
        {
            $agreement_id = 'AGR - '.$rows['agreement_id'];
            $invoice = $rows['invoiceId'];
            $deliveryDate = $rows['productlink'];
            $orderName = strtoupper($rows['pname']);
            $color = $rows['color'];
            $size = $rows['size'];
            $quantity = $rows['quantity'];
            $swatchImageName = $rows['swatch'];
            $payment_terms = $rows['payment_term'];
            $conditon = $rows['order_condition'];
            $salesName = $rows['salesperson'];

            //CUSTOMER DETAILS
            $customerName = $rows['customer_name'];
            $customerAddress = $rows['customer_address'];
            $customerEmail = $rows['customer_email'];
            $customerPhone = $rows['customer_phone'];


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
            
            if(empty($swatchImageName)){
                $swatch_image = $swatch_upload_dir.'No Swatch.png';
            }else{
                $swatch_image = $swatch_upload_dir.$swatchImageName;
            }
        }

        $pdf=new FPDF();
        //NEW PAGE
        $pdf->AddPage();
        $pdf->AliasNbPages();
        /**
         * *************************************************************************************************
         * FIRST SECTION
         * LOGO AND TOPIC
         * *************************************************************************************************
         */
        $pdf->Image($logoURL,11,5);
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(0,5,'SALES AGREEMENT',0,0,'R');
        $pdf->Ln();
        /**
         * *************************************************************************************************
         * SECOND SECTION
         * ADDRESS AND HEAD - FIRST LINE
         * *************************************************************************************************
         */
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(118,35,'Prime Business Centre - Office #1005 - B',0,0,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,12,'AGREEMENT ID',0,0,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,12,$agreement_id,0,0,'R');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(-32,28,'INV / NO',0,0,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,28,$invoice,0,0,'R');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(-32,45,'DELIVERY DATE',0,0,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,45,$deliveryDate,0,0,'R');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(-32,62,'SALES SOURCE',0,0,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,62,$salesName,0,0,'R');

        $pdf->Ln(40);
        /**
         * *************************************************************************************************
         * THIRD SECTION
         * ADDRESS AND HEAD - SECOND LINE
         * *************************************************************************************************
         */
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(118,-35,'Jumeira Village Circle, Dubai - UAE',0,0,'L');

        $pdf->Ln(-10);
        /**
         * *************************************************************************************************
         * FOURTH SECTION
         * CUSTOMER DETAILS
         * *************************************************************************************************
         */
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(0,10,'CUSTOMER DETAILS',0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,5,'NAME : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$customerName,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,5,'ADDRESS : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$customerAddress,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,5,'EMAIL : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$customerEmail,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,5,'MOBILE : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$customerPhone,0,0,'L');

        $pdf->Ln(15);

        /**
         * *************************************************************************************************
         * SIXTH SECTION
         * PAYMENT TERMS BOX
         * *************************************************************************************************
         */
        $pdf->Cell(0,80,'',1,0,'L');
        $pdf->Ln(8);
        /**
         * *************************************************************************************************
         * FIFTH SECTION
         * PRODUCT DETAILS
         * *************************************************************************************************
         */


        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(0,0,'PRODUCT DETAILS',0,0,'L');
        $pdf->Image($image, 130, 95, 60, 60);
        $pdf->Ln(-5);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(92,30,$orderName,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,-15,'COLOR : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,-15,$color,0,0,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(22,-20,'SIZE : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,-20,$size,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,35,'',0,0,'L');
        $pdf->Cell(22,35,'QUANTITY : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,35,$quantity,0,0,'L');
        $pdf->Ln(22);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(5,35,'',0,0,'L');
        $pdf->Cell(30,5,'COLOR SWATCH',0,0,'L');
        $pdf->Ln(8);
      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(6,35,'',0,0,'L');
        $pdf->Image($swatch_image, 17, 138, 19, 19);
        // $pdf->Cell(20,20,'',1,1,'L');

        $pdf->Ln(40);


        /**
         * *************************************************************************************************
         * SEVENTH SECTION
         * PAYMENT TERMS
         * *************************************************************************************************
         */
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(0,0,'PAYMENT TERMS',0,0,'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5,35,'',0,0,'L');
        $pdf->Cell(0,0,$payment_terms,0,0,'L');

        $pdf->Ln(10);

        /**
         * *************************************************************************************************
         * SEVENTH SECTION
         * CONDITION BOX
         * *************************************************************************************************
         */

        /**
         * *************************************************************************************************
         * NINTH SECTION
         * ORDER CONDITION
         * *************************************************************************************************
         */

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(5,0,'',0,0,'L');
        $pdf->Cell(0,0,'CONDITIONS',0,0,'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5,35,'',0,0,'L');
        $pdf->Cell(0,0,$conditon,0,0,'L');
        $pdf->Ln(40);

        /**
         * *************************************************************************************************
         * TENTH SECTION
         * SIGNATURE SECTION
         * *************************************************************************************************
         */
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(120,0,'',0,0,'L');
        $pdf->Cell(80,0,$userName,0,0,'C');
        $pdf->Ln(5);

        $pdf->Cell(95,0,'------------------------------------------------',0,0,'L');
        $pdf->Cell(95,0,'------------------------------------------------',0,0,'R');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60,0,'CUSTOMER SIGNATURE',0,0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(200,0,'ADMIN AUTHORITY',0,0,'C');


        $pdf->SetY(-1);
        $pdf->SetFont('Arial','',12);
        $pdf->Output();
    }
?>