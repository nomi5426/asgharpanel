<?php
    include "../base/db.php";
    include '../base/deliveryNoteDownload.php';

    $upload_dir = '../uploads/';

    $request = $_REQUEST;
    $status = $_POST['status'];
    //$nextStatus = $_POST['nextStatus'];

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
        10   =>  'city',
    );

    //SEARCH
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
        //Days Given and Days Left
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
        //IMAGE
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
        $comment = $row[17];
        if($comment == null){
            $comment = "N/A";
        }
        //FETCH ITEM NAME AND SIZE
        $oneRow = "$row[6] | <strong>Color: $row[9]</strong><br><strong> Size - $row[8]</strong>";
        $deliveryNotePrint = "<a href=../deliveryNoteDownload.php?file_id=$row[0]>$row[4]";
        //MATERIAL AVAILABILITY
        $material = $row[16];
        $materialAvailable = 'Yes';
        //SUBDATA
        $subdata[]=$deliveryNotePrint;
        $subdata[]=$row[15];
        $subdata[]=$dateAvailability;
        $subdata[]=$row[3];
        $subdata[]=$interval;
        $subdata[]=$oneRow;
        $subdata[]=$row[10];
        $subdata[]=$row[12];
        $subdata[]=$row[13];
        $subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
        $subdata[]=$comment;
        $subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
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