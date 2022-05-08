<?php
include "db.php";

if (!session_id()) session_start();

function app_log($message){
    $logfile = 'log/log_'.date('d-M-Y').'.log';
    file_put_contents($logfile, $message . "\n", FILE_APPEND);
}   
if(isset($_SESSION['login']))
{
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Admin User '".$_SESSION['login']."' is logged out. ");
}
else if(isset($_SESSION['userlogin']))
{
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Factory User '".$_SESSION['userlogin']."' is logged out. ");
}
else if(isset($_SESSION['salesLogin']))
{
    //LOG
    date_default_timezone_set('Asia/Dubai');
    app_log("'".date('d-m-Y H:i:s')."' : Sales User '".$_SESSION['salesLogin']."' is logged out. ");
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