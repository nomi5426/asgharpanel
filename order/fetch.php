<?php
    session_start();
    include "../base/db.php";
    include '../base/deliveryNoteDownload.php';

    $upload_dir = '../uploads/';

    //GET USER ROLE
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= "SELECT * FROM user WHERE username='".$username."'";
        $queryInject = mysqli_query($conn, $userDetail);
        if(mysqli_num_rows($queryInject)){
            while($row = mysqli_fetch_assoc($queryInject)) {
            $firstName = $row['firstname'];
            $userrole = $row['userrole'];
            }	
        }
    }

    $request = $_REQUEST;
    $status = $_POST['status'];
    $nextStatus = $_POST['nextStatus'];

    $col =array(
        0   =>  'invoiceId',
        1   =>  'productlink',
        2   =>  'pname',
        3   =>  'size',
        4   =>  'color',
        5   =>  'quantity',
        7   =>  'ordernote',
        8   =>  'salesperson',
        9   =>  'pimage',
        10   =>  'city'
    );
    // $sql ="SELECT * FROM product where pstatus = 'New Order'";
    // $query=mysqli_query($conn,$sql);
    // $totalData=mysqli_num_rows($query);
    // $totalFilter=$totalData;
    // SEARCH
    if(!empty($status)){
        $sql ="SELECT * FROM product WHERE 1=1 and pstatus='".$status."'";
    }else{
        $sql ="SELECT * FROM product WHERE 1=1";
    }

    if(!empty($request['search']['value'])){
        $sql.=" AND (invoiceId Like '".$request['search']['value']."%') ";
        //$sql.=" OR invoiceId Like '".$request['search']['value']."%' ";
    }
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
        $request['start']."  ,".$request['length']."  ";
    $query=mysqli_query($conn,$sql);

    $data=array();
    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        
        //DAYS GIVEN AND LEFT
        $productlinkToSec = strtotime($row[1]);
        $insertDateToSec = strtotime(Date('Y-m-d'));
        $timeDiff = ($productlinkToSec - $insertDateToSec);
        $interval = $timeDiff/86400;
        $interval = intval($interval);
        if ($interval < 0) {
            $interval = 0;
        }
        if (($row['dateAvailability']) !==''){
            $dateAvailability=($row['dateAvailability']);
        }
        else{
            $dateAvailability='N/A';
        }

        //IMAGE RETRIEVE
        if($row[7]!==''){ 
            if(strpos($upload_dir.$row[7],',') !== false){
                $arr = explode(',', $row[7]);
                $image = $arr[0];
            }
            else{
                $image = $row[7];
            }
        }
        else{
            $noImage = 'No Image.jpg';
            $image = $noImage;
        }

        //COMMENT
        $comment = $row[17];
        if($comment == null){
            $comment = "N/A";
        }

        //FETCH ITEM
        $oneRow = "$row[6]<br><strong> Size - $row[8]</strong>";
        $deliveryNotePrintqr = "<a href=../base/deliveryNoteDownload.php?file_id=$row[0]>$row[4]</a><br><a href='../qrcodes/$row[22]' target='_blank'><img src='../qrcodes/$row[22]' /></a> ";
        $qrcodeinvoicefordelivery = "$row[4]";
        $deliveryNotePrint = "<a href=../base/deliveryNoteDownload.php?file_id=$row[0]>$row[4]";


        //MATERIAL AVAILABILITY
        $material = $row[16];
        $materialAvailable = 'Yes';

        //ADMIN
        if($userrole == "superadmin"){
            $subdata[]=$deliveryNotePrint;
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            if($status == "New Order"){
                if ($material !== $materialAvailable){
                // $subdata[]='<div class="inner"><button id="materialConfirm" title="Confirm Material" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-tick"></i></button>
                //             <button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
                    $subdata[]='<div class="inner"><button id="_materialLpo" type="button" title="Confirm Material" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#materialLpoModal" data-id="'.$row[0].'"><i class="typcn typcn-tick"></i></button></button>            
                            <button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
                }
                else{
                    $subdata[]='<button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button>';            
                }
            }
            else if($status == ''){
                $subdata[]=$row[11];
                $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$row[20];
        }

        else if($userrole == "admin"){
            $subdata[]=$deliveryNotePrint;
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            if($status == "New Order"){
                if ($material !== $materialAvailable){
                    $subdata[]='<div class="inner"><button id="materialConfirm" title="Material Confirm" class="btn btn-primary btn-icon" data-id="'.$row[0].'" disabled><i class="typcn typcn-tick"></i></button></div>
                                <div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
                }
                else{
                    $subdata[]='<button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button>';          
                }
            }
            else if($status == ''){
                $subdata[]=$row[11];
                $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$row[20];
        }

        //SALES
        else if($userrole == "sales"){
            $subdata[]=$deliveryNotePrint;
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            if($status == "New Order"){
                if ($material !== $materialAvailable){
                    $subdata[]='<div class="inner"><button id="materialConfirm" title="Material Confirm" class="btn btn-primary btn-icon" data-id="'.$row[0].'" disabled><i class="typcn typcn-tick"></i></button></div>';
                }
                else{
                    $subdata[]='';
                }
            }
            else if($status == ''){
                $subdata[]=$row[11];
                $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$row[20];
        }

        //FACTORY
        else if($userrole == "factory"){
            $subdata[]=$deliveryNotePrintqr; 
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            if($status == "New Order"){
                if ($material !== $materialAvailable){
                $subdata[]='<div class="inner"><button id="_materialLpo" type="button" title="Confirm Material" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#materialLpoModal" data-id="'.$row[0].'"><i class="typcn typcn-tick"></i></button></button>
                            <div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
                }
                else{
                $subdata[]='<button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button>';
                            
                }
            }
            else if($status == ''){
                $subdata[]=$row[11];
                $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$row[20];
        }

        else if($userrole == "staff"){
            $subdata[]=$deliveryNotePrint;
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            if($status == "New Order"){
                if ($material !== $materialAvailable){
                $subdata[]='<div class="inner"><button id="materialConfirm" title="Material Confirm" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-tick"></i></button></div>
                            <div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
                }
                else{
                $subdata[]='<button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button>';
                            
                }
            }
            else if($status == ''){
                $subdata[]=$row[11];
                $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$row[20];
        }        
        else if($userrole == "delivery"){
            $subdata[]=$qrcodeinvoicefordelivery;
            $subdata[]=$row[15];
            $subdata[]=$dateAvailability;
            $subdata[]=$row[3];
            $subdata[]=$interval;
            $subdata[]=$oneRow;
            $subdata[]=$row[9];
            $subdata[]=$row[10];
            $subdata[]=$row[12];
            $subdata[]=$row[13];
            $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
            $subdata[]=$comment;
            $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-arrow-right"></i></button></div>';
        }

        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
?>