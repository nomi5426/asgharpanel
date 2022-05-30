<?php
include "../base/db.php";
    /**
     * DECLARED VARIABLES FOR GET USER DETAIL
     */
    if (!session_id()) session_start();

    //CURRENT TIMESTAMP
	function curdate() {
		date_default_timezone_set('Asia/Dubai'); 
		return date('Y-m-d');
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
    
            if($orderStatus == "New Order"){
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
                $statusChangeQuery = "update product set pstatus = 'Out for Delivery' where id=".$statusid;
                $statusChangeMessage = "Order status has been changed to Out for Delivery";
                $response['index'] = 1;
            }
            else if($orderStatus == "Out for Delivery"){
                $statusChangeQuery = "update product set pstatus = 'Delivered' where id=".$statusid;
                $statusChangeMessage = "Order status has been changed to Delivered";
                $response['index'] = 1;
            }
            else if($orderStatus == "On Hold"){
                $changeQuery = $conn->query("update product set pstatus = 'New Order', material = 'No' where id=".$statusid);
                $statusChangeMessage = "Order status has been changed to New Order from On Hold";
                if($changeQuery){
                    $statusChangeQuery = "DELETE FROM order_staff WHERE order_id=".$statusid;
                    $response['index'] = 1;
                }
            }
            else if($orderStatus == "Cancelled"){
                $changeQuery = $conn->query("update product set pstatus = 'New Order', material = 'No' where id=".$statusid);
                $statusChangeMessage = "Order status has been changed to New Order from Cancelled";
                if($changeQuery){
                    $statusChangeQuery = "DELETE FROM order_staff WHERE order_id=".$statusid;
                    $response['index'] = 1;
                }
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

            $currentDate = curdate();
            $all = $newcomment.' - '.$currentDate;

            $_staffAssociate = $conn->query("SELECT * FROM order_staff WHERE order_id = ".$id);

            if($newStatus == "New Order"){
                $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus', material = 'No' WHERE id = '$id'");
                if($commentUpdate){
                    $delStat = $conn->query("DELETE FROM order_staff WHERE order_id=".$id);
                    $response['index'] = 1;
                }
            }
            else{
                if($currentStatus == "New Order"){
                    $mat_select = $conn->query("SELECT * FROM product WHERE id=".$id);
                    $row = mysqli_fetch_array($mat_select);
                    $matAvail = $row['material'];
                    if($matAvail == 'Yes'){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        $response['index'] = 1;
                    }
                    else{
                        $response['index'] = 2;
                    }
                }
                else if($currentStatus == "In Production"){
                    if(mysqli_num_rows($_staffAssociate) !== 0){
                        $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                        if($commentUpdate){
                            $response['index'] = 1;
                        }
                    }
                    else{
                        //QUERY SHOULD BE TESTED
                        if($newStatus !== "New Order"){
                            $response['index'] = 3;
                        }else{
                            $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus', material = 'No' WHERE id = '$id'");
                            $response['index'] = 1;
                        }
                    }
                }
                else if($currentStatus == "On Hold" || $currentStatus == "Cancelled"){
                    $updateQuery = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus', material='No' WHERE id = '$id'");
                    $statusChangeMessage = "Order status has been changed to " .$newStatus;
                    if($updateQuery){
                        $statusChangeQuery = $conn->query("DELETE FROM order_staff WHERE order_id=".$id);
                        $response['index'] = 1;
                    }
                }
                else{
                    $commentUpdate = $conn->query("UPDATE product SET userComment = CONCAT(IFNULL(userComment,''),'$all'), pstatus = '$newStatus' WHERE id = '$id'");
                    if($commentUpdate){
                        $response['index'] = 1;
                    }
                }
            }
        }     
    }catch(Exception $errMessage){
        echo 'RZDAUNTE exception: ',  $errMessage->getMessage(), "\n";
    }

    if(isset($_POST['confirmOrder'])){
        $confirmOrder = $_POST['confirmOrder'];
        $sql = "SELECT * FROM product WHERE id='".$confirmOrder."'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);

        $pendingStatus = $row['pstatus'];
        $pendingStatusQuery="";

        if($pendingStatus == "Pending"){
            $pendingStatusQuery = "update product set pstatus = 'New Order' where id=".$confirmOrder;
        }
        $result = mysqli_query($conn, $pendingStatusQuery);
        if($result){
            $newQuery = "INSERT INTO order_approval(order_id, consultant_id, is_approved) VALUES('".$confirmOrder."','".$userId."','".$isApproved."')";
        }
        $insert_result = mysqli_query($conn, $newQuery);
        if($insert_result){
            $response['index'];
        }
    }
    echo json_encode($response);
?>