<?php
    session_start();
    include "../base/db.php";
    include '../base/deliveryNoteDownload.php';

    $upload_dir = '../uploads/';

	/**
	 * GETS CURRENT TIME AND RETURNS AS LOCAL TIME
	 */
	function _curDate() {
		date_default_timezone_set('Asia/Dubai');
		return date('Y-m-d');
	}

    //GET USER ROLE
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= $conn->query("SELECT * FROM user WHERE username='".$username."'");
        if(mysqli_num_rows($userDetail)){
            while($row = mysqli_fetch_assoc($userDetail)) {
                $_firstName = $row['firstname'];
                $_userRole = $row['userrole'];
                $_userDepartment = $row['department'];
            }
        }
    }

    $request = $_REQUEST;
    $status = $_POST['status'];

    $col =array(
        0   =>  'invoiceID'
    );

    // SEARCH
    if(!empty($status)){
        if(!empty($request['search']['value'])){
            $sql ="SELECT prod.*, 
                    cx.customer_phone 
                FROM product AS prod 
                INNER JOIN customer as cx ON 
                    prod.id = cx.order_id 
                WHERE 1=1 
                AND 
                    prod.invoiceId LIKE '%".$request['search']['value']."%'
                OR
                    cx.customer_phone LIKE '%".$request['search']['value']."%'
                AND pstatus='".$status."'
                ORDER BY productlink";

        }else{
            $sql ="SELECT * FROM product WHERE 1=1 AND pstatus='".$status."' ORDER BY productlink ";
        }
    }else{
        if(!empty($request['search']['value'])){
            $sql ="SELECT prod.*, 
                    cx.customer_phone 
                FROM product AS prod 
                LEFT JOIN customer as cx ON 
                    prod.id = cx.order_id 
                WHERE 1=1
            AND 
                invoiceId LIKE '%".$request['search']['value']."%'
            OR
                customer_phone LIKE '%".$request['search']['value']."%'
            ORDER BY productlink";
        }else{
            $sql ="SELECT * FROM product WHERE 1=1 ORDER BY productlink";
        }
    }

    // if(!empty($request['search']['value'])){
    //     $sql.=" AND (invoiceId LIKE '%".$request['search']['value']."%') ";
    //     //$sql.=" OR invoiceId Like '".$request['search']['value']."%' ";
    // }else{
    //     $sql.="";
    // }
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    // $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    //     $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($conn,$sql);
    $data=array();
    
    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        /**
         * VALUES FROM DB - TABLE {PRODUCT} ASSIGNED TO LOCAL VARIABLES
         */
        $_id = $row[0];                     //UNIQUE ID - PRIMARY KEY
        $_insertDate = $row[1];             //RECORD ENTRY DATE - DATE
        $_branchId = $row[2];               //BRANCH ID - WHERE THE ORDER FROM
        $_city = $row[3];                   //WHERE THE ORDER WILL BE DELIVERED
        $_invoiceId = $row[4];              //INVOICE ID OF THE ORDER
        $_deliveryNote = $row[5];           //DELIVERY NOTE OF AN ORDER - WILL BE SAVED IN A FOLDER
        $_orderName = $row[6];              //ORDER NAME
        $_orderImage = $row[7];             //ORDER IMAGE - IF ITS MULTIPLE, FILE NAMES WILL BE SAVED COMMA SEPERATED - WILL BE SAVED IN A FOLDER
        $_orderSize = $row[8];              //ORDER SIZE
        $_orderColor = $row[9];             //ORDER COLOR
        $_orderQuantity = $row[10];         //ORDER QUANTITY
        $_orderStatus = $row[11];           //STATUS OF AN ORDER
        $_orderNote = $row[12];             //NOTE FOR THE ORDER
        $_salesperson = $row[13];           //SALES PERSON WHO IS RESPONSIBLE
        $_categoryId = $row[14];            //CATEGORY OF A PARTICULAR ORDER
        $_deliveryDate = $row[15];          //WHEN THE ORDER SHOULD BE DELIVERED
        $_orderMaterial = $row[16];         //MATERIAL FOR THE ORDER - IF AVAILABLE DEFAULT VALUE - YES
        $_orderComment = $row[17];          //COMMENT FOR THE ORDER
        $_daysGiven = $row[18];             //DAYS GIVEN FOR THE ORDER TO BE MADE
        $_createdBy = $row[19];             //WHO CREATED THE ORDER
        $_editedBy = $row[20];              //WHO EDITS THE ORDER
        $_statusChangedBy = $row[21];       //WHO CHANGE THE STATUS OF THE ORDER
        $_qrcode = $row[22];                //UNIQUE QR CODE FOR THE ORDER FOR TRACKING PURPOSES - WILL BE SAVED IN A FOLDER
        
        //AS PER TABLE COLUMN
        //INVOICE ID WITH - WITHOUT DELIVERY NOTE AS PER ROLES
        $_invoiceIdWithDN = "<a href=../base/deliveryNoteDownload.php?file_id=$_id>$_invoiceId";
        $_invoiceIdWithDNQR = "<a href=../base/deliveryNoteDownload.php?file_id=$_id>$_invoiceId</a><br><a href='../qrcodes/$_qrcode' target='_blank'><img src='../qrcodes/$_qrcode' /></a>";
        //DAYS LEFT FROM DELIVERY DATE
        $_deliveryDateToSec = strtotime($_deliveryDate);
        $_currentDateToSec = strtotime(_curDate());
        $_diffInSec = $_deliveryDateToSec - $_currentDateToSec;
        $_diffInDays = $_diffInSec/86400;
        $_roundDay = intval($_diffInDays);
        //ITEM NAME AND SIZE
        $_nameAndSize = "$_orderName<br><strong> Size - $_orderSize</strong>";
        //IMAGE RETRIEVE
        if($_orderImage!==''){
            if(strpos($upload_dir.$_orderImage,',') !== false){
                $arr = explode(',', $_orderImage);
                $_image = $arr[0];
            }
            else{
                $_image = $_orderImage;
            }
        }else{
            $noImage = 'No Image.jpg';
            $_image = $noImage;
        }
        //COMMENT
        $_userComment = $_orderComment;
        if($_userComment == null){
            $_userComment = "N/A";
        }
        //MATERIAL AVAILABILITY
        $materialAvailable = 'Yes';

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: SUPER ADMIN
         */

        $subdata[]=$_invoiceIdWithDN;
        $subdata[]=$_deliveryDate;
        $subdata[]=$_daysGiven;
        $subdata[]=$_city;
        $subdata[]=$_roundDay;
        $subdata[]=$_nameAndSize;
        $subdata[]=$_orderColor;
        $subdata[]=$_orderQuantity;
        $subdata[]=$_orderNote;
        $subdata[]='<img src="'.$upload_dir.$_image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$_id.'"/>';
        $subdata[]=$_userComment;
        $subdata[]=$_orderStatus;
        $subdata[]=$_salesperson;
        $subdata[]= '<div class="inner"><a title="Print" href="../print/customizePrint.php?action=select&id='.$_id.'" target="_blank" class="btn btn-primary btn-icon"><i class="typcn typcn-document-text"></i></a></div>';

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