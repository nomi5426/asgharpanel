<?php
    include "../base/db.php";
    /**
     * DECLARED VARIABLES FOR GET USER DETAIL
     */
    if (!session_id()) session_start();

    //CURRENT TIMESTAMP
	function curdate() {
		date_default_timezone_set('Asia/Dubai'); 
		return date('Y-m-d H:i');
	}

	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */
	function app_log($message){
        $logPath  = "../log/log_";
		date_default_timezone_set('Asia/Dubai');
		$logfile = $logPath.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}

    $isApproved=1;
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= $conn->query("SELECT * FROM user WHERE username='".$username."'");
        while($row = mysqli_fetch_assoc($userDetail)) {
            $_userId = $row['id'];
			$_userName = $row['username'];
            $_firstName = $row['firstname'];
            $_userRole = $row['userrole'];
        }
    }

    $response['index'] = 1;

    try{
        if(isset($_POST['statusid'])){
            $statusid = $_POST['statusid'];
            $sql = "SELECT * FROM product WHERE id='".$statusid."'";
            $query=mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($query);
    
            $orderStatus = $row['pstatus'];
            $materialStatus = $row['material'];

            $statusChangeQuery = "";

            if($orderStatus == "CRM"){
                $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'New Order', material = 'No' WHERE id=".$statusid);
                $response['index'] = 1;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM CRM is moved to New Order and Material set to Null - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
            }
            else if($orderStatus == "New Order"){
                if($materialStatus !== 'Yes'){
                    $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'New Order' WHERE id=".$statusid);
                    $response['index'] = 2;
                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM New Order was tried to move to In Production. - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                }else{
                    $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'In Production' WHERE id=".$statusid);
                    $response['index'] = 1;
                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM New Order to In Production - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                }
            }
            else if($orderStatus == "In Production"){
                $response['index'] = 3;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM In Production to Ready. - SUCCESS - Goes to add_staff_order for Production Staff by User : '".$_userName."' ROOT: statusChange.php");
            }
            else if($orderStatus == "Ready"){
                $response['index'] = 4;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM Ready to Out for Delivery. - SUCCESS - Goes to add_staff_order for Delivery Staff by User : '".$_userName."' ROOT: statusChange.php");
            }
            else if($orderStatus == "Out for Delivery"){
                $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'Delivered' WHERE id=".$statusid);
                $response['index'] = 1;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM Out for Delivery to Delivered - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
            }
            else if($orderStatus == "On Hold"){
                $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'Ready' WHERE id=".$statusid);
                $response['index'] = 1;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM On Hold to Ready - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
            }
            else if($orderStatus == "Cancelled"){
                $statusChangeQuery = $conn->query("UPDATE product SET pstatus = 'Ready' WHERE id=".$statusid);
                $response['index'] = 1;
                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' FROM Cancelled to Ready - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
            }
            if($statusChangeQuery){
                $response['index'];
            }
        }
    }catch(Exception $errMessage){
        echo 'RZDAUNTE exception: ',  $errMessage->getMessage(), "\n";
        date_default_timezone_set('Asia/Dubai');
        app_log("'".date('d-m-Y H:i:s')."' : Order '".$statusid."' 
        ERROR TO BE CHECKED. ERROR: '".$errMessage ->getMessage()."' 
        - FAILED - by User : '".$_userName."' ROOT: statusChange.php");
    }
    
    try{
        if(isset($_POST['s_id']) || isset($_POST['newcomment']) || isset($_POST['currentstatus']) || isset($_POST['newstatus'])){
            $id = $_POST['s_id'];
            $newcomment = $_POST['newcomment'];
            $currentStatus = $_POST['currentstatus'];
            $newStatus = $_POST['newstatus'];

            $mat_select = $conn->query("SELECT * FROM product WHERE id=".$id);
            $row = mysqli_fetch_array($mat_select);
            $matAvail = $row['material'];

            $currentDate = curdate();
            $all = $newcomment.' - '.$currentDate."</br>";

            if($newStatus == "New Order" || $newStatus == "CRM"){
                $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), 
                pstatus = '$newStatus', material = 'No'
                WHERE id = '$id'");

                date_default_timezone_set('Asia/Dubai');
                app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                '".$newStatus."' from '".$currentStatus."' AND Material is set to Null with 
                Comment : '".$newcomment."'
                - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                if($currentStatus !== "In Production"){
                    if($currentStatus == "Ready"){
                        $delStat = $conn->query("UPDATE order_staff_production SET active_status = 0 WHERE order_id=$id");

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' AND Disabled production Staffs
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    }else{
                        $delStat = $conn->query("UPDATE order_staff_production osp,
                        order_staff_delivery osd SET 
                        osp.active_status = 0,
                        osd.active_status = 0
                        WHERE osp.order_id = $id
                        AND osd.order_id = $id");

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' AND Disabled production and Delivery Staffs
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                    if($delStat){
                        $response['index'] = 1;
                    }
                }
            }
            else if($newStatus == "In Production"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), 
                        pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with 
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to In Production. 
                        - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), 
                    pstatus = '$newStatus' WHERE id = '$id'");

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                    '".$newStatus."' from '".$currentStatus."' with 
                    Comment : '".$newcomment."'
                    - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    if($currentStatus !== "In Production"){
                        if($currentStatus == "Ready"){
                            $delStat = $conn->query("UPDATE order_staff_production SET active_status = 0 WHERE order_id=$id");

                            date_default_timezone_set('Asia/Dubai');
                            app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                            '".$newStatus."' from '".$currentStatus."' AND Disabled production Staffs
                            - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                        }else{
                            $delStat = $conn->query("UPDATE order_staff_production osp,
                            order_staff_delivery osd SET 
                            osp.active_status = 0,
                            osd.active_status = 0
                            WHERE osp.order_id = $id
                            AND osd.order_id = $id");

                            date_default_timezone_set('Asia/Dubai');
                            app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                            '".$newStatus."' from '".$currentStatus."' AND Disabled production and Delivery Staffs
                            - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                        }
                        if($delStat){
                            $response['index'] = 1;
                        }
                    }
                }
            }else if($newStatus == "Ready"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), 
                        pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to Ready.
                        - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else if($currentStatus == "In Production"){
                        $response['index'] = 3;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                        FROM In Production to Ready. - 
                        SUCCESS - Goes to add_staff_order for Production Staff
                        by User : '".$_userName."' ROOT: statusChange.php");
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                    '".$newStatus."' from '".$currentStatus."' with 
                    Comment : '".$newcomment."'
                    - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    if($commentUpdate){
                        $delStat = $conn->query("UPDATE order_staff_delivery SET active_status = 0 WHERE order_id =".$id);

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        Disabled Delivery Staffs From New Status : Ready, Current Status : '".$currentStatus."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                        $response['index'] = 1;
                    }
                }
            }else if($newStatus == "Out for Delivery"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to Out for Delivery. 
                        - FAILED -  Due to Material marking - 
                        by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else if($currentStatus == "In Production"){
                    $response['index'] = 3;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM In Production to Out for Delivery. 
                    - ATTEMPT - Goes to add_staff_order for Production Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");

                }else if($currentStatus == "Ready"){
                    $response['index'] = 4;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM Ready to Out for Delivery.
                    - ATTEMPT - Goes to add_staff_order for Delivery Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    
                    if($commentUpdate){

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                        $response['index'] = 1;
                    }
                }              
            }else if($newStatus == "Delivered"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to Delivered. 
                        - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else if($currentStatus == "In Production"){
                    $response['index'] = 3;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM In Production to Delivered.
                    - ATTEMPT - Goes to add_staff_order for Production Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");

                }else if($currentStatus == "Ready"){
                    $response['index'] = 4;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM Ready to Delivered.
                    - ATTEMPT - Goes to add_staff_order for Delivery Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                        $response['index'] = 1;
                    }
                }              
            }else if($newStatus == "On Hold"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to On Hold. 
                        - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else if($currentStatus == "In Production"){
                    $response['index'] = 3;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM In Production to On Hold.
                    - ATTEMPT - Goes to add_staff_order for Production Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");

                }else if($currentStatus == "Ready"){
                    $response['index'] = 4;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM Ready to On Hold.
                    - ATTEMPT - Goes to add_staff_order for Delivery Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){

                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    }
                }              
            }else if($newStatus == "Cancelled"){
                if($currentStatus == "New Order" || $currentStatus == "CRM"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");

                    }else{
                        $response['index'] = 2;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' 
                        FROM '".$currentStatus."' was tried to move to Cancelled. 
                        - FAILED -  Due to Material marking - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }else if($currentStatus == "In Production"){
                    $response['index'] = 3;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM In Production to Cancelled.
                    - ATTEMPT - Goes to add_staff_order for Production Staff by User : '".$_userName."' ROOT: statusChange.php");

                }else if($currentStatus == "Ready"){
                    $response['index'] = 4;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."'
                    FROM Ready to Cancelled.
                    - ATTEMPT - Goes to add_staff_order for Delivery Staff 
                    by User : '".$_userName."' ROOT: statusChange.php");
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){
                        $response['index'] = 1;

                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                        '".$newStatus."' from '".$currentStatus."' with
                        Comment : '".$newcomment."'
                        - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }              
            }
            else{
                $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                if($commentUpdate){
                    $response['index'] = 1;

                    date_default_timezone_set('Asia/Dubai');
                    app_log("'".date('d-m-Y H:i:s')."' : Order '".$id."' Status is changed to 
                    '".$newStatus."' from '".$currentStatus."' with
                    Comment : '".$newcomment."'
                    - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                }
            }
        }     
    }catch(Exception $errMessage){
        echo 'RZDAUNTE exception: ',  $errMessage->getMessage(), "\n";
    }

    if(isset($_POST['confirmOrder'])){
        $confirmOrder = $_POST['confirmOrder'];
        $orderConfirmationQuery = $conn->query("SELECT * FROM product WHERE id='".$confirmOrder."'");
        $row = mysqli_fetch_array($orderConfirmationQuery);

        $pendingStatus = $row['pstatus'];
        $pendingStatusQuery="";

        $agreementPath='';
        $checkAgrementEmpty = $conn->query("SELECT * FROM sales_agreement WHERE order_id = '".$confirmOrder."'");
        while ($pathRow = mysqli_fetch_array($checkAgrementEmpty)){
            $agreementPath = $pathRow['sales_agreement_path'];
        }

        if($agreementPath !== 'Not Exists'){
            if($pendingStatus == "Pending"){
                $pendingStatusQuery = $conn->query("UPDATE product SET pstatus = 'New Order' WHERE id=".$confirmOrder);
                if($pendingStatusQuery){
                    $newQuery = $conn->query("INSERT INTO order_approval(order_id, consultant_id, is_approved) VALUES('".$confirmOrder."','".$_userId."','".$isApproved."')");
                    if($newQuery){
                        $response['index'] = 2;
                        date_default_timezone_set('Asia/Dubai');
                        app_log("'".date('d-m-Y H:i:s')."' : Order '".$confirmOrder."'
                        is Approved - SUCCESS - by User : '".$_userName."' ROOT: statusChange.php");
                    }
                }
            }
        }else{
            $response['index'] = 3;

            date_default_timezone_set('Asia/Dubai');
            app_log("'".date('d-m-Y H:i:s')."' : Order '".$confirmOrder."'
            is missing Sales Agreement by User : '".$_userName."' ROOT: statusChange.php");
        }

    }
    echo json_encode($response);
?>