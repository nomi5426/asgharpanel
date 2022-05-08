<?php
include "../base/db.php";

if(isset($_POST['statusid'])){
    $statusid = $_POST['statusid'];
    $sql = "SELECT * FROM product WHERE id='".$statusid."'";
    $query=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);

    $orderStatus = $row['pstatus'];
    $statusChangeQuery = "";
    $statusChangeMessage = "";

    if($orderStatus == "New Order"){
        $statusChangeQuery = "update product set pstatus = 'In Production' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to In Production";
    }
    else if($orderStatus == "In Production"){
        $statusChangeQuery = "update product set pstatus = 'Ready' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to Ready";
    }
    else if($orderStatus == "Ready"){
        $statusChangeQuery = "update product set pstatus = 'Out for Delivery' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to Out for Delivery";
    }
    else if($orderStatus == "Out for Delivery"){
        $statusChangeQuery = "update product set pstatus = 'Delivered' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to Delivered";
    }
    else if($orderStatus == "On Hold"){
        $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to Delivered";
    }
    else if($orderStatus == "Cancelled"){
        $statusChangeQuery = "update product set pstatus = 'New Order' where id=".$statusid;
        $statusChangeMessage = "Order status has been changed to Delivered";
    }
	$result = mysqli_query($conn,$statusChangeQuery);
	if($result){
        echo "<script type='text/javascript'>alert('$statusChangeMessage')</script>";
	}
}


if(isset($_POST['materialid'])){
    $materialid = $_POST['materialid'];
    $sql = "SELECT * FROM product WHERE id='".$materialid."'";
    $query=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query);

    $materialStatus = $row['pstatus'];
    $materialAvilabilityQuery="";

    if($materialStatus !== "Yes"){
        $materialAvilabilityQuery = "update product set material = 'Yes' where id=".$materialid;
    }
    $result = mysqli_query($conn,$materialAvilabilityQuery);
	if($result){
        echo "<script type='text/javascript'>alert('DONE')</script>";
	}
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
    $result = mysqli_query($conn,$pendingStatusQuery);
	if($result){
        echo "<script type='text/javascript'>alert('DONE')</script>";
	}
}
?>