<?php
include "fpdf.php";
include "../base/db.php";

$upload_dir = '../uploads/';

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
        $pdf->Image($logoURL,10,6);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,5,'Order Detail',0,0,'R');
        $pdf->Ln();
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(75,30,'Prime Business Centre - Office #1005 - B',0,0,'C');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(92,10,'INV / NO',0,0,'R');
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(0,10,$rows['invoiceId'],0,0,'R');
        $pdf->Ln(30);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(65,-15,'Jumeira Village Circle, Dubai - UAE',0,0,'C');
        $pdf->SetFont('Arial','',13);
        $pdf->Cell(100,-35,'Del / Date :',0,0,'R');
        $pdf->Cell(0,-35,$rows['productlink'],0,0,'R');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(132,-15,'Item & Description',0,0,'L');
        $pdf->Cell(18,-15,'City',0,0,'C');
        $pdf->Cell(10,-15,'Qty',0,0,'C');
        $pdf->Cell(15,-15,'S/P',0,0,'C');
        $pdf->Cell(15,-15,'Branch',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(132,35,$rows['pname'],0,0,'L');
        $pdf->Cell(18,35,$rows['city'],0,0,'C');
        $pdf->Cell(10,35,$rows['quantity'],0,0,'C');
        $pdf->Cell(15,35,$rows['salesperson'],0,0,'C');
        $pdf->Cell(15,35,$rows['orderId'],0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(13,-20,'Color : ',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(135,-20,$rows['color'],0,0,'L');
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(11,40,'Size :',0,0,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(135,40,$rows['size'],0,0,'L');
        $pdf->Ln(25);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,10,'Order Note',0,0,'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,$rows['ordernote'],0,0,'L');
        $pdf->Ln(10);

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