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

    $userId=1;
    $isApproved=1;
    $firstname='';
    //GET USER ROLE
    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= "SELECT * FROM user WHERE username='".$username."'";
        $queryInject = mysqli_query($conn, $userDetail);
        if(mysqli_num_rows($queryInject)){
            while($row = mysqli_fetch_assoc($queryInject)) {
                $userId = $row['id'];
            }
        }
    }

    //GET USER NAME
    if(isset($_SESSION["userName"])){
        $username = $_SESSION['userName'];
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
            $statusChangeMessage = "";

            if($orderStatus == "CRM"){
                $statusChangeQuery = "update product set pstatus = 'New Order', material = 'No' where id=".$statusid;
                $statusChangeMessage = "Order status has been changed to New Order";
                $response['index'] = 1;
            }
            else if($orderStatus == "New Order"){
                if($materialStatus !== 'Yes'){
                    $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;
                    $statusChangeMessage = "Please Confirm Material Availability";
                    $response['index'] = 2;
                }else{
                    $statusChangeQuery = "update product set pstatus = 'In Production' where id=".$statusid;
                    $statusChangeMessage = "Order status has been changed to In Production";
                    $response['index'] = 1;
                }
            }
            else if($orderStatus == "In Production"){
                $_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE order_id = ".$statusid);
                if(mysqli_num_rows($_staffAssociate)!=0){
                    $statusChangeQuery = "update product set pstatus = 'Ready' where id=".$statusid;
                    $statusChangeMessage = "Order status has been changed to Ready";
                    $response['index'] = 1;
                }else{
                    $statusChangeQuery = "update product set pstatus = 'In Production' where id=".$statusid;
                    $statusChangeMessage = "Staff should be added, Order is at In Production, wasn't changed";
                    $response['index'] = 3;
                }
            }
            else if($orderStatus == "Ready"){
                $statusChangeQuery = "update product set pstatus = 'Ready' where id=".$statusid;
                $statusChangeMessage = "Delivery staff should be added, Order is at Ready, wasn't changed";
                $response['index'] = 4;
            }
            else if($orderStatus == "Out for Delivery"){
                $statusChangeQuery = "update product set pstatus = 'Delivered' where id=".$statusid;
                $statusChangeMessage = "Order status has been changed to Delivered";
                $response['index'] = 1;
            }
            else if($orderStatus == "On Hold"){
                $statusChangeQuery = $conn->query("update product set pstatus = 'Ready' where id=".$statusid);
                $statusChangeMessage = "Order status has been changed to Ready from On Hold";
                $response['index'] = 1;
            }
            else if($orderStatus == "Cancelled"){
                $statusChangeQuery = $conn->query("update product set pstatus = 'Ready' where id=".$statusid);
                $statusChangeMessage = "Order status has been changed to Ready from Cancelled";
                $response['index'] = 1;
            }
            $result = mysqli_query($conn,$statusChangeQuery);
            if($result){
                $response['index'];
            }
        }
    }catch(Exception $errMessage){
        echo 'RZDAUNTE exception: ',  $errMessage->getMessage(), "\n";
    }
    
    try{
        if(isset($_POST['s_id']) || isset($_POST['newcomment']) || isset($_POST['currentstatus']) || isset($_POST['newstatus'])){
            $id = $_POST['s_id'];
            $newcomment = $_POST['newcomment'];
            $currentStatus = $_POST['currentstatus'];
            $newStatus = $_POST['newstatus'];

            //IN PRODUCTION SECTION
            $mat_select = $conn->query("SELECT * FROM product WHERE id=".$id);
            $row = mysqli_fetch_array($mat_select);
            $matAvail = $row['material'];

            $currentDate = curdate();
            $all = $newcomment.' - '.$currentDate."</br>";

            $_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE order_id = ".$id);

            if($newStatus == "New Order"){
                $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus', material = 'No' WHERE id = '$id'");
                if($commentUpdate){
                    $delStat = $conn->query("DELETE FROM order_staff WHERE order_id=".$id);
                    $response['index'] = 1;
                }
            }
            else if($newStatus == "In Production"){
                if($currentStatus == "New Order"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 2;
                    }
                }else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){
                        $delStat = $conn->query("DELETE FROM order_staff WHERE order_id=".$id);
                        $response['index'] = 1;
                    }
                }
            }
            else if($newStatus == "Ready"){
                if($currentStatus == "New Order"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 2;
                    }
                }else if($currentStatus == "In Production"){
                    if(mysqli_num_rows($_staffAssociate) != 0){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 3;
                    }
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){
                        $delStat = $conn->query("UPDATE order_staff SET del_staff_id = 17 WHERE order_id =".$id);
                        $response['index'] = 1;
                    }
                }
            }else if($newStatus == "Out for Delivery"){
                if($currentStatus == "New Order"){
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 2;
                    }
                }else if($currentStatus == "In Production"){
                    if(mysqli_num_rows($_staffAssociate) != 0){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 3;
                    }
                }else if($currentStatus == "Ready"){
                    if(mysqli_num_rows($_staffAssociate) != 0){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }else{
                        $response['index'] = 4;
                    }
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){
                        $delStat = $conn->query("UPDATE order_staff SET del_staff_id = 17 WHERE order_id =".$id);
                        $response['index'] = 1;
                    }
                }              
            }
            else{
                $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                if($commentUpdate){
                    $response['index'] = 1;
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
                    $newQuery = $conn->query("INSERT INTO order_approval(order_id, consultant_id, is_approved) VALUES('".$confirmOrder."','".$userId."','".$isApproved."')");
                    if($pendingStatusQuery){
                        $response['index'] = 2;
                    }
                }
            }
        }else{
            $response['index'] = 3;
        }
    }
    echo json_encode($response);
?>