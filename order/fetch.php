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

    // SEARCH
    if(!empty($status)){
        if($status == 'Ready'){
            $sql ="SELECT
                        prod.id,
                        prod.insertDate,
                        prod.branchId,
                        prod.city,
                        prod.invoiceId,
                        prod.deliveryNote,
                        prod.pname,
                        prod.pimage,
                        prod.size,
                        prod.color,
                        prod.quantity,
                        prod.pstatus,
                        prod.ordernote,
                        prod.salesperson,
                        prod.cat_id,
                        prod.productlink,
                        prod.material,
                        prod.userComment,
                        prod.dateAvailability,
                        prod.createdBy,
                        prod.editedBy,
                        prod.statusChangedBy,
                        prod.qrcode,
                        GROUP_CONCAT(DISTINCT stf.id SEPARATOR ', ') AS staff_id,
                        GROUP_CONCAT(DISTINCT stf.staff_name SEPARATOR ', ') AS production_staff_name,
                        GROUP_CONCAT(DISTINCT delstf.id SEPARATOR ', ') AS del_staff_id,
                        GROUP_CONCAT(DISTINCT delstf.staff_name SEPARATOR ', ') AS del_staff_name
                    FROM order_staff_production osp 
                    LEFT JOIN product AS prod ON 
                        prod.id = osp.order_id 
                    LEFT JOIN order_staff_delivery osd ON
                    	prod.id = osd.order_id
                    LEFT JOIN staff AS delstf ON
                    	delstf.id = osd.del_staff_id
                    LEFT JOIN staff AS stf ON 
                        stf.id = osp.staff_id
                    WHERE 1=1 AND 
                        osp.active_status = 1
                    AND
                        prod.pstatus = 'Ready'
                    GROUP BY osp.order_id";
        }
        else if($status == 'Out for Delivery'){
            $sql ="SELECT
                        prod.id,
                        prod.insertDate,
                        prod.branchId,
                        prod.city,
                        prod.invoiceId,
                        prod.deliveryNote,
                        prod.pname,
                        prod.pimage,
                        prod.size,
                        prod.color,
                        prod.quantity,
                        prod.pstatus,
                        prod.ordernote,
                        prod.salesperson,
                        prod.cat_id,
                        prod.productlink,
                        prod.material,
                        prod.userComment,
                        prod.dateAvailability,
                        prod.createdBy,
                        prod.editedBy,
                        prod.statusChangedBy,
                        prod.qrcode,
                        GROUP_CONCAT(DISTINCT stf.id SEPARATOR ', ') AS staff_id,
                        GROUP_CONCAT(DISTINCT stf.staff_name SEPARATOR ', ') AS production_staff_name,
                        GROUP_CONCAT(DISTINCT delstf.id SEPARATOR ', ') AS del_staff_id,
                        GROUP_CONCAT(DISTINCT delstf.staff_name SEPARATOR ', ') AS del_staff_name
                    FROM order_staff_production osp 
                    LEFT JOIN product AS prod ON 
                        prod.id = osp.order_id 
                    LEFT JOIN order_staff_delivery osd ON
                    	prod.id = osd.order_id
                    LEFT JOIN staff AS delstf ON
                    	delstf.id = osd.del_staff_id
                    LEFT JOIN staff AS stf ON 
                        stf.id = osp.staff_id
                    WHERE 1=1 AND 
                        osp.active_status = 1
                    AND
                        osd.active_status = 1
                    AND
                        prod.pstatus = 'Out for Delivery'
                    GROUP BY osp.order_id";
        }
        else{
            $sql ="SELECT * FROM product WHERE 1=1 AND pstatus='".$status."'";
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
        if($userrole == "superadmin"){
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
            if($status == "New Order"){
                if ($_orderMaterial !== $materialAvailable){
                    $subdata[]=$_salesperson;
                    $subdata[]='<div class="inner"><button id="_materialLpo" type="button" title="Confirm Material" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#materialLpoModal" data-id="'.$_id.'"><i class="typcn typcn-tick"></i></button></div>';
                }
            }
            else if($status == "Ready"){
                $subdata[]=$row[24];
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            else if($status == "Out for Delivery"){
                $subdata[]=$row[26];
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            else if($status == ''){
                $subdata[]=$_orderStatus;
                $subdata[]=$_salesperson;
                $subdata[]= '<div class="inner"><a title="Print" href="../print/customizePrint.php?action=select&id='.$_id.'" target="_blank" class="btn btn-primary btn-icon"><i class="typcn typcn-document-text"></i></a></div>';
            }else{
                $subdata[]=$_salesperson;
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$_editedBy;
        }

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: ADMIN
         */
        else if($userrole == "admin"){
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
            if($status == "New Order"){
                if ($_orderMaterial !== $materialAvailable){
                    $subdata[]=$_salesperson;
                    $subdata[]='<div class="inner"><button id="_materialLpo" type="button" title="Confirm Material" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#materialLpoModal" data-id="'.$_id.'"><i class="typcn typcn-tick"></i></button></div>';
                }
            }
            else if($status == "Ready"){
                $subdata[]=$row[24];
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            else if($status == "Out for Delivery"){
                $subdata[]=$row[26];
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            else if($status == ''){
                $subdata[]=$_orderStatus;
                $subdata[]=$_salesperson;
                $subdata[]= '<div class="inner"><a title="Print" href="../print/customizePrint.php?action=select&id='.$_id.'" target="_blank" class="btn btn-primary btn-icon"><i class="typcn typcn-document-text"></i></a></div>';
            }else{
                $subdata[]=$_salesperson;
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$_editedBy;
        }

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: SALES
         */
        else if($userrole == "sales"){
            $subdata[]=$_invoiceIdWithDN;
            $subdata[]=$_deliveryDate;
            $subdata[]=$_daysGiven;
            $subdata[]=$_city;
            $subdata[]=$_roundDay;
            $subdata[]=$_nameAndSize;
            $subdata[]=$_orderColor;
            $subdata[]=$_orderQuantity;
            $subdata[]=$_orderNote;
            $subdata[]=$_salesperson;
            $subdata[]='<img src="'.$upload_dir.$_image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$_id.'"/>';
            $subdata[]=$_userComment;
            if($status == "New Order"){
                if ($_orderMaterial !== $materialAvailable){
                    $subdata[]='<div class="inner"><button id="materialConfirm" title="Material Confirm" class="btn btn-primary btn-icon" data-id="'.$_id.'" disabled><i class="typcn typcn-tick"></i></button></div>';
                }
            }
            else if($status == "Ready"){
                $subdata[]=$row[24];
            }
            else if($status == "Out for Delivery"){
                $subdata[]=$row[26];
            }
            else if($status == ''){
                $subdata[]=$_orderStatus;
            }
            $subdata[]=$_editedBy;
        }

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: FACTORY
         */
        else if($userrole == "factory"){
            $subdata[]=$_invoiceIdWithDN;
            $subdata[]=$_deliveryDate;
            $subdata[]=$_daysGiven;
            $subdata[]=$_city;
            $subdata[]=$_roundDay;
            $subdata[]=$_nameAndSize;
            $subdata[]=$_orderColor;
            $subdata[]=$_orderQuantity;
            $subdata[]=$_orderNote;
            $subdata[]=$_salesperson;
            $subdata[]='<img src="'.$upload_dir.$_image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$_id.'"/>';
            $subdata[]=$_userComment;
            if($status == "New Order"){
                if ($_orderMaterial !== $materialAvailable){
                    $subdata[]='<div class="inner"><button id="_materialLpo" type="button" title="Confirm Material" class="btn btn-primary btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#materialLpoModal" data-id="'.$_id.'"><i class="typcn typcn-tick"></i></button></div>';
                }
            }
            else if($status == "Ready"){
                $subdata[]=$row[24];
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            else if($status == "Out for Delivery"){
                $subdata[]=$row[26];
            }
            else if($status == ''){
                $subdata[]=$_orderStatus;
                $subdata[]= '<div class="inner"><a title="Print" href="../print/customizePrint.php?action=select&id='.$_id.'" target="_blank" class="btn btn-primary btn-icon"><i class="typcn typcn-document-text"></i></a></div>';
            }else{
                $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';
            }
            $subdata[]=$_editedBy;
        }

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: FACTORY STAFFS
         */
        else if($userrole == "staff"){
            $subdata[]=$_invoiceId;
            $subdata[]=$_deliveryDate;
            $subdata[]=$_daysGiven;
            $subdata[]=$_city;
            $subdata[]=$_roundDay;
            $subdata[]=$_nameAndSize;
            $subdata[]=$_orderColor;
            $subdata[]=$_orderQuantity;
            $subdata[]=$_orderNote;
            $subdata[]=$_salesperson;
            $subdata[]='<img src="'.$upload_dir.$_image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$_id.'"/>';
            $subdata[]=$_userComment;
        }

        /**
         * BELOW WILL BE THE AUTHORIZATION AND PRIVILIGAES 
         * THAT THE USER HAVE WITH THE SYSTEM.
         * IT IS LIMITED AS PER USER'S ROLE
         * 
         * USER ROLE: DELIVERY
         */  
        else if($userrole == "delivery"){
            $subdata[]=$_invoiceIdWithDNQR;
            $subdata[]=$_deliveryDate;
            $subdata[]=$_daysGiven;
            $subdata[]=$_city;
            $subdata[]=$_roundDay;
            $subdata[]=$_nameAndSize;
            $subdata[]=$_orderColor;
            $subdata[]=$_orderQuantity;
            $subdata[]=$_orderNote;
            $subdata[]=$_salesperson;
            $subdata[]='<img src="'.$upload_dir.$_image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$_id.'"/>';
            $subdata[]=$_userComment;
            $subdata[]='<div class="inner"><button id="statusChangeNext" title="Next" class="btn btn-primary btn-icon" data-id="'.$_id.'"><i class="typcn typcn-arrow-right"></i></button></div>';

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