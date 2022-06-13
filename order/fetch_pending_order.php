<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: SEND REQUESTED COLUMNS FROM APPROVE_ORDER.PHP
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
    include "../base/db.php";
    include '../base/deliveryNoteDownload.php';
    $upload_dir = '../uploads/';

    //KEEP TRACK ON SESSION VARIABLES
    session_start();

    $request = $_REQUEST;
    $status = $_POST['status'];

    /**
     * GET USER ROLE AND NAME OF LOGGED IN USER
     */
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

    //Search
    if(!empty($status)){
    if($userrole=="superadmin"){
        $sql ="SELECT * FROM product WHERE 1=1 AND pstatus='".$status."'";
    }
    else if($userrole=="admin"){
        $sql ="SELECT * FROM product WHERE 1=1 AND pstatus='".$status."'";
    }
    else if($userrole=="sales"){
        $sql ="SELECT * FROM product WHERE 1=1 AND pstatus='".$status."' AND salesperson='".$firstName."'";
    }
    }else{
        $sql ="SELECT * FROM product WHERE 1=1";
    }

    if(!empty($request['search']['value'])){
        $sql.=" AND (invoiceId Like '".$request['search']['value']."%') ";
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

        //COMMENT
        $comment = $row[17];
        if($comment == null){
            $comment = "N/A";
        }

        //GET ITEM AND NAME
        $oneRow = "$row[6]<br><strong> Size - $row[8]</strong>";
        $deliveryNotePrint = "<a href=deliveryNoteDownload.php?file_id=$row[0]>$row[4]";

        //MATERIAL
        $material = $row[16];
        $materialAvailable = 'Yes';

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
        $subdata[]='<div class="inner"><button id="confirmOrder" title="Approve Order" class="btn btn-primary btn-icon" data-id="'.$row[0].'"><i class="typcn typcn-thumbs-ok"></i></button>
                    <button id="editOrderApprove" type="button" title="Edit Order" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#editOrderApproveModal" data-id="'.$row[0].'"><i class="typcn typcn-pen"></i></button></div>';
        $subdata[]=$row[16];
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