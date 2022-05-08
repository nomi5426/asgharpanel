<?php
session_start();

if (isset($_SESSION['userlogin']))
$_SESSION['userlogin'] = $_SESSION['userlogin']; 
?>