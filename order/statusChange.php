<?php
include "../base/db.php";
    /**
     * DECLARED VARIABLES FOR GET USER DETAIL
     */
    $userId=1;
    $isApproved=1;
    $firstname='';
    //GET USER ROLE
    // if(isset($_SESSION['userName'])){
    //     $username = $_SESSION['userName'];
    //     $userDetail= "SELECT * FROM user WHERE username='".$username."'";
    //     $queryInject = mysqli_query($conn, $userDetail);
    //     if(mysqli_num_rows($queryInject)){
    //         while($row = mysqli_fetch_assoc($queryInject)) {
    //             $userId = $row['id'];
    //         }
    //     }
    // }

    //GET USER NAME
    if(isset($_SESSION["userName"])){
        $username = $_SESSION['userName'];
    }

    $response['index'] = 1;

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
                $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;;
                $statusChangeMessage = "Please Confirm Material Availability";
                $response['index'] = 2;
            }else{
                $statusChangeQuery = "update product set pstatus = 'In Production' where id=".$statusid;
                $statusChangeMessage = "Order status has been changed to In Production";$response['index'] = 1;
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
                $statusChangeMessage = "Order status has been changed to Ready";
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
            $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;
            $statusChangeMessage = "Order status has been changed to Delivered";
            $response['index'] = 1;
        }
        else if($orderStatus == "Cancelled"){
            $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;
            $statusChangeMessage = "Order status has been changed to Delivered";
            $response['index'] = 1;
        }
        $result = mysqli_query($conn,$statusChangeQuery);
        if($result){
            $response['index'];
        }
    }

    if(isset($_POST['statusPrev'])){
        $prevStatusId = $_POST['statusPrev'];
        $sql = "SELECT * FROM product WHERE id='".$prevStatusId."'";
        $query=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $orderStatus = $row['pstatus'];
        $statusChangeQuery = "";
        $statusChangeMessage = "";
    
        if($orderStatus == "In Production"){
            $statusChangeQuery = "UPDATE product SET pstatus = 'New Order', statusChangedBy = '$username' WHERE id=".$prevStatusId;
            $statusChangeMessage = "Order status has been changed to New Order";
            $response['index'] = 1;
        }
        else if($orderStatus == "Ready"){
            $statusChangeQuery = "UPDATE product SET pstatus = 'In Production', statusChangedBy = '$username' WHERE id=".$prevStatusId;
            $statusChangeMessage = "Order status has been changed to In Production";
            $response['index'] = 1;
            
        }
        else if($orderStatus == "Out For Delivery"){
            $statusChangeQuery = "UPDATE product SET pstatus = 'Ready', statusChangedBy = '$username' WHERE id=".$prevStatusId;
            $statusChangeMessage = "Order status has been changed to Ready";
            $response['index'] = 1;
        }
        $result = mysqli_query($conn,$statusChangeQuery);
        if($result){
            $response['index'];
        }
    }
    
    //  OLD MATERIAL WITH BUTTON
    //  if(isset($_POST['materialid'])){
    //     $materialid = $_POST['materialid'];
    //     $sql = "SELECT * FROM product WHERE id='".$materialid."'";
    //     $query=mysqli_query($conn,$sql);
    //     $row = mysqli_fetch_array($query);

    //     $materialStatus = $row['pstatus'];
    //     $materialAvilabilityQuery="";

    //     if($materialStatus !== "Yes"){
    //         $materialAvilabilityQuery = "update product set material = 'Yes' where id=".$materialid;
    //     }
    //     $result = mysqli_query($conn,$materialAvilabilityQuery);
    // 	if($result){
    //         echo "<script type='text/javascript'>alert('DONE')</script>";
    // 	}
    // }
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
            echo "<script type='text/javascript'>alert('DONE')</script>";
        }
    }
    header('Content-type: application/json');
    echo json_encode($response);
?>