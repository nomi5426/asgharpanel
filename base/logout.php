<?php
include "db.php";

if (!session_id()) session_start();

function app_log($message){
    $logfile = 'log/log_'.date('d-M-Y').'.log';
    file_put_contents($logfile, $message . "\n", FILE_APPEND);
}   
if(isset($_SESSION['_superAdminLogin'])){
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Super Admin User '".$_SESSION['_superAdminLogin']."' is logged out. ");
}
else if(isset($_SESSION['_adminLogin'])){
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Admin User '".$_SESSION['_adminLogin']."' is logged out. ");
}
else if(isset($_SESSION['_salesLogin'])){
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Sales User '".$_SESSION['_salesLogin']."' is logged out. ");
}
else if(isset($_SESSION['_factoryLogin'])){
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Factory User '".$_SESSION['_factoryLogin']."' is logged out. ");
}
else if(isset($_SESSION['_staffLogin'])){
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Staff User '".$_SESSION['_staffLogin']."' is logged out. ");
}
// else
// {
//     date_default_timezone_set('Asia/Dubai');
//     app_log("'".date('d-m-Y H:i:s')."' : User attempted to logout when session is expired. ");
// }
session_destroy();
header("Location: ../index.php");
die();
?>