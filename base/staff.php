<?php
//if (!session_id()) session_start();
session_start();
include "db.php";
if (!isset($_SESSION['userlogin'])) 
{ 
  date_default_timezone_set('Asia/Dubai');
  header("Location:index.php");
  app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt Factory User");
}

//Log Writing
function app_log($message){
date_default_timezone_set('Asia/Dubai');
$logfile = 'log/log_'.date('d-M-Y').'.log';
file_put_contents($logfile, $message . "\n", FILE_APPEND);
} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->
		<title> Asghar Furniture LLC - Order Management </title>

        <!--ZAID - SSP DATATABLE-->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Favicon -->
		<link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="assets/css/icons.css" rel="stylesheet">

		<!---Internal  Prism css-->
		<link href="assets/plugins/prism/prism.css" rel="stylesheet">

		<!---Internal Input tags css-->
		<link href="assets/plugins/inputtags/inputtags.css" rel="stylesheet">

		<!---Internal Owl Carousel css-->
		<link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">

		<!---Internal  Multislider css-->
		<link href="assets/plugins/multislider/multislider.css" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- Internal Data table css -->
		<link href="assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link href="assets/plugins/datatable/css/buttons.bootstrap4.min.css" rel="stylesheet">
		<link href="assets/plugins/datatable/css/responsive.bootstrap4.min.css" rel="stylesheet" />
		<link href="assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
		<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

		<!--  Custom Scroll bar-->
		<link href="assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- Select2 css --->
		<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

		<!--- Style css-->
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="assets/css/animate.css" rel="stylesheet">

	</head>

	<body class="main-body">

		<!-- Loader -->
		<div id="global-loader">
			<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<!-- main-header opened -->
			<div class="main-header nav nav-item hor-header top-header">
				<div class="container">
					<div class="main-header-left ">
						<a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
						<a class="header-brand" href="index.php">
							<img src="assets/img/brand/logo-white.png" class="desktop-dark">
							<img src="assets/img/brand/logo.png" class="desktop-logo">
							<img src="assets/img/brand/favicon.png" class="desktop-logo-1">
							<img src="assets/img/brand/favicon-white.png" class="desktop-logo-dark">
						</a>
						<a class="header-brand header-brand2 d-none d-lg-block" href="index.php">
							<img src="assets/img/brand/logo-white.png" class="desktop-dark">
							<img src="assets/img/brand/logo.png" class="desktop-logo">
							<img src="assets/img/brand/favicon.png" class="desktop-logo-1">
							<img src="assets/img/brand/favicon-white.png" class="desktop-logo-dark">
						</a>
						<div class="main-header-center  ml-4">
							<input class="form-control" placeholder="Search for Order.." type="text" id="orderSearchText"><button class="btn"><i class="fe fe-search"></i></button>
						</div>
					</div><!-- search -->
					<div class="main-header-right">
						<ul class="nav">
							<li class="">
								<div class="dropdown  nav-itemd-none d-md-flex">
									<a href="#" class="d-flex  nav-item nav-link pr-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
										<span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img src="assets/img/flags/us_flag.jpg" alt="img"></span>
										<div class="my-auto">
											<strong class="mr-2 ml-2 my-auto">English</strong>
										</div>
									</a>
									<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
										<a href="#" class="dropdown-item d-flex ">
											<span class="avatar  mr-3 align-self-center bg-transparent"><img src="assets/img/flags/french_flag.jpg" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">French</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar  mr-3 align-self-center bg-transparent"><img src="assets/img/flags/germany_flag.jpg" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Germany</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar mr-3 align-self-center bg-transparent"><img src="assets/img/flags/italy_flag.jpg" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Italy</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar mr-3 align-self-center bg-transparent"><img src="assets/img/flags/russia_flag.jpg" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">Russia</span>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex">
											<span class="avatar  mr-3 align-self-center bg-transparent"><img src="assets/img/flags/spain_flag.jpg" alt="img"></span>
											<div class="d-flex">
												<span class="mt-2">spain</span>
											</div>
										</a>
									</div>
								</div>
							</li>
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>
							<div class="dropdown nav-item main-header-message ">
								<a class="new nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg><span class=" pulse-danger"></span></a>
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-left">
										<div class="d-flex">
											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Messages</h6>
											<span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
										</div>
										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread messages</p>
									</div>
									<div class="main-message-list chat-scroll">
										<a href="#" class="p-3 d-flex border-bottom">
											<div class="  drop-img  cover-image  " data-image-src="assets/img/faces/3.jpg">
												<span class="avatar-status bg-teal"></span>
											</div>
											<div class="wd-90p">
												<div class="d-flex">
													<h5 class="mb-1 name">Petey Cruiser</h5>
												</div>
												<p class="mb-0 desc">I'm sorry but i'm not sure how to help you with that......</p>
												<p class="time mb-0 text-left float-left ml-2 mt-2">Mar 15 3:55 PM</p>
											</div>
										</a>
										<a href="#" class="p-3 d-flex border-bottom">
											<div class="drop-img cover-image" data-image-src="assets/img/faces/2.jpg">
												<span class="avatar-status bg-teal"></span>
											</div>
											<div class="wd-90p">
												<div class="d-flex">
													<h5 class="mb-1 name">Jimmy Changa</h5>
												</div>
												<p class="mb-0 desc">All set ! Now, time to get to you now......</p>
												<p class="time mb-0 text-left float-left ml-2 mt-2">Mar 06 01:12 AM</p>
											</div>
										</a>
										<a href="#" class="p-3 d-flex border-bottom">
											<div class="drop-img cover-image" data-image-src="assets/img/faces/9.jpg">
												<span class="avatar-status bg-teal"></span>
											</div>
											<div class="wd-90p">
												<div class="d-flex">
													<h5 class="mb-1 name">Graham Cracker</h5>
												</div>
												<p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
												<p class="time mb-0 text-left float-left ml-2 mt-2">Feb 25 10:35 AM</p>
											</div>
										</a>
										<a href="#" class="p-3 d-flex border-bottom">
											<div class="drop-img cover-image" data-image-src="assets/img/faces/12.jpg">
												<span class="avatar-status bg-teal"></span>
											</div>
											<div class="wd-90p">
												<div class="d-flex">
													<h5 class="mb-1 name">Donatella Nobatti</h5>
												</div>
												<p class="mb-0 desc">Here are some products ...</p>
												<p class="time mb-0 text-left float-left ml-2 mt-2">Feb 12 05:12 PM</p>
											</div>
										</a>
										<a href="#" class="p-3 d-flex border-bottom">
											<div class="drop-img cover-image" data-image-src="assets/img/faces/5.jpg">
												<span class="avatar-status bg-teal"></span>
											</div>
											<div class="wd-90p">
												<div class="d-flex">
													<h5 class="mb-1 name">Anne Fibbiyon</h5>
												</div>
												<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
												<p class="time mb-0 text-left float-left ml-2 mt-2">Jan 29 03:16 PM</p>
											</div>
										</a>
									</div>
									<div class="text-center dropdown-footer">
										<a href="text-center">VIEW ALL</a>
									</div>
								</div>
							</div>
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-left">
										<div class="d-flex">
											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Notifications</h6>
											<span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
										</div>
										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread Notifications</p>
									</div>
									<div class="main-notification-list Notification-scroll">
										<a class="d-flex p-3 border-bottom" href="#">
											<div class="notifyimg bg-pink">
												<i class="la la-file-alt text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">New files available</h5>
												<div class="notification-subtext">10 hour ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
										<a class="d-flex p-3" href="#">
											<div class="notifyimg bg-purple">
												<i class="la la-gem text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">Updates Available</h5>
												<div class="notification-subtext">2 days ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
										<a class="d-flex p-3 border-bottom" href="#">
											<div class="notifyimg bg-success">
												<i class="la la-shopping-basket text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">New Order Received</h5>
												<div class="notification-subtext">1 hour ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
										<a class="d-flex p-3 border-bottom" href="#">
											<div class="notifyimg bg-warning">
												<i class="la la-envelope-open text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">New review received</h5>
												<div class="notification-subtext">1 day ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
										<a class="d-flex p-3 border-bottom" href="#">
											<div class="notifyimg bg-danger">
												<i class="la la-user-check text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">22 verified registrations</h5>
												<div class="notification-subtext">2 hour ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
										<a class="d-flex p-3 border-bottom" href="#">
											<div class="notifyimg bg-primary">
												<i class="la la-check-circle text-white"></i>
											</div>
											<div class="ml-3">
												<h5 class="notification-label mb-1">Project has been approved</h5>
												<div class="notification-subtext">4 hour ago</div>
											</div>
											<div class="ml-auto" >
												<i class="las la-angle-right text-right text-muted"></i>
											</div>
										</a>
									</div>
									<div class="dropdown-footer">
										<a href="">VIEW ALL</a>
									</div>
								</div>
							</div>
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href=""><img alt="" src="assets/img/faces/6.jpg"></a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user"><img alt="" src="assets/img/faces/6.jpg" class=""></div>
											<div class="ml-3 my-auto">
												<h6>Petey Cruiser</h6><span>Premium Member</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
									<a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
									<a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
									<a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
									<a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>
									<a class="dropdown-item" href="page-signin.html"><i class="bx bx-log-out"></i> Sign Out</a>
								</div>
							</div>
							<!-- <div class="dropdown main-header-message right-toggle">
								<a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
								</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<!-- /main-header -->

			<!--Horizontal-main -->
			<div class="sticky">
				<div class="horizontal-main hor-menu clearfix side-header">
					<div class="horizontal-mainwrapper container clearfix">
						<!--Nav-->
						<nav class="horizontalMenu clearfix">
							<ul class="horizontalMenu-list">
								<li aria-haspopup="true"><a href="index.php" class=""><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>Dashboard</a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg> Order<i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" opacity=".3"/><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg> NAV 3<i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg> NAV 4<i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 10 6.5 10s1.5.67 1.5 1.5S7.33 13 6.5 13zm3-4C8.67 9 8 8.33 8 7.5S8.67 6 9.5 6s1.5.67 1.5 1.5S10.33 9 9.5 9zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 6 14.5 6s1.5.67 1.5 1.5S15.33 9 14.5 9zm4.5 2.5c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5.67-1.5 1.5-1.5 1.5.67 1.5 1.5z" opacity=".3"/><path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.61-.23-1.21-.64-1.67-.08-.09-.13-.21-.13-.33 0-.28.22-.5.5-.5H16c3.31 0 6-2.69 6-6 0-4.96-4.49-9-10-9zm4 13h-1.77c-1.38 0-2.5 1.12-2.5 2.5 0 .61.22 1.19.63 1.65.06.07.14.19.14.35 0 .28-.22.5-.5.5-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.14 8 7c0 2.21-1.79 4-4 4z"/><circle cx="6.5" cy="11.5" r="1.5"/><circle cx="9.5" cy="7.5" r="1.5"/><circle cx="14.5" cy="7.5" r="1.5"/><circle cx="17.5" cy="11.5" r="1.5"/></svg> NAV 5 <i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10.9 19.91c.36.05.72.09 1.1.09 2.18 0 4.16-.88 5.61-2.3L14.89 13l-3.99 6.91zm-1.04-.21l2.71-4.7H4.59c.93 2.28 2.87 4.03 5.27 4.7zM8.54 12L5.7 7.09C4.64 8.45 4 10.15 4 12c0 .69.1 1.36.26 2h5.43l-1.15-2zm9.76 4.91C19.36 15.55 20 13.85 20 12c0-.69-.1-1.36-.26-2h-5.43l3.99 6.91zM13.73 9h5.68c-.93-2.28-2.88-4.04-5.28-4.7L11.42 9h2.31zm-3.46 0l2.83-4.92C12.74 4.03 12.37 4 12 4c-2.18 0-4.16.88-5.6 2.3L9.12 11l1.15-2z" opacity=".3"/><path d="M12 22c5.52 0 10-4.48 10-10 0-4.75-3.31-8.72-7.75-9.74l-.08-.04-.01.02C13.46 2.09 12.74 2 12 2 6.48 2 2 6.48 2 12s4.48 10 10 10zm0-2c-.38 0-.74-.04-1.1-.09L14.89 13l2.72 4.7C16.16 19.12 14.18 20 12 20zm8-8c0 1.85-.64 3.55-1.7 4.91l-4-6.91h5.43c.17.64.27 1.31.27 2zm-.59-3h-7.99l2.71-4.7c2.4.66 4.35 2.42 5.28 4.7zM12 4c.37 0 .74.03 1.1.08L10.27 9l-1.15 2L6.4 6.3C7.84 4.88 9.82 4 12 4zm-8 8c0-1.85.64-3.55 1.7-4.91L8.54 12l1.15 2H4.26C4.1 13.36 4 12.69 4 12zm6.27 3h2.3l-2.71 4.7c-2.4-.67-4.35-2.42-5.28-4.7h5.69z"/></svg> NAV 6 <i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24" ><g><rect fill="none"/></g><g><g/><g><path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><path d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z" opacity=".3"/></g><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z"/><path d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z"/><path d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z"/></g></g></svg>NAV 7 <i class="fe fe-chevron-down horizontal-icon"></i></a></li>
								<li aria-haspopup="true"><a href="widgets.html" class=""><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" opacity=".3"/><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg> NAV 8 </a></li>
								<li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg> NAV 9 <i class="fe fe-chevron-down horizontal-icon"></i></a></li>
							</ul>
						</nav>
						<!--Nav-->
					</div>
				</div>
			</div>
			<!--Horizontal-main -->

			<!-- main-content opened -->
			<div class="main-content horizontal-content">
				<!-- container opened -->
				<div class="container">
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								<h4 class="content-title mb-0 my-auto">Tables</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Data Tables</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="pr-1 mb-3 mb-xl-0">
								<button type="button" class="btn btn-info btn-icon mr-2"><i class="mdi mdi-filter-variant"></i></button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
								<button type="button" class="btn btn-danger btn-icon mr-2"><i class="mdi mdi-star"></i></button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
								<button type="button" class="btn btn-warning  btn-icon mr-2"><i class="mdi mdi-refresh"></i></button>
							</div>
							<div class="mb-3 mb-xl-0">
								<div class="btn-group dropdown">
									<button type="button" class="btn btn-primary">14 Aug 2019</button>
									<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
										<a class="dropdown-item" href="#">2015</a>
										<a class="dropdown-item" href="#">2016</a>
										<a class="dropdown-item" href="#">2017</a>
										<a class="dropdown-item" href="#">2018</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- breadcrumb -->
					<!-- row opened -->
					<div class="row row-sm">
						<!--div-->
						<div class="col-xl-12">
							<div class="card mg-b-20">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<h4 class="card-title mg-b-0">SERVER SIDE PROCESSING</h4>
										<i class="mdi mdi-dots-horizontal text-gray"></i>
									</div>
									<p class="tx-12 tx-gray-500 mb-2">with AJAX</p>
								</div>
								<div class="card-body">
									<div class="panel panel-primary tabs-style-1">
										<div class=" tab-menu-heading">
											<div class="tabs-menu1">
												<!-- Tabs -->
												<ul class="nav panel-tabs main-nav-line">
													<li class="nav-item"><a href="#neworder" class="nav-link active" data-toggle="tab">New Order</a></li>
													<li class="nav-item"><a href="#inproduction" class="nav-link" data-toggle="tab">In Production</a></li>
													<li class="nav-item"><a href="#ready" class="nav-link" data-toggle="tab">Ready</a></li>
													<li class="nav-item"><a href="#outfordelivery" class="nav-link" data-toggle="tab">Out for Delivery</a></li>
													<li class="nav-item"><a href="#delivered" class="nav-link" data-toggle="tab">Delivered</a></li>
													<li class="nav-item"><a href="#onhold" class="nav-link" data-toggle="tab">On Hold</a></li>
													<li class="nav-item"><a href="#cancelled" class="nav-link" data-toggle="tab">Cancelled</a></li>
													<li class="nav-item"><a href="#allproduct" class="nav-link" data-toggle="tab">All Product</a></li>
												</ul>
											</div>
										</div>
										<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
											<div class="tab-content">
												<div class="tab-pane active" id="neworder">
													<div class="table-responsive">
														<table id="exampleone" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Action</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="inproduction">
													<div class="table-responsive">
														<table id="exampletwo" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Action</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="ready">
													<div class="table-responsive">
														<table id="examplethree" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Action</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="outfordelivery">
													<div class="table-responsive">
														<table id="examplefour" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Action</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="delivered">
													<div class="table-responsive">
														<table id="examplefive" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="onhold">
													<div class="table-responsive">
														<table id="examplesix" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="cancelled">
													<div class="table-responsive">
														<table id="exampleseven" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="allproduct">
													<div class="table-responsive">
														<table id="exampleeight" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Size</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consultant</th>
																	<th class="border-bottom-0">Image</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal" id="imagemodalone">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div id="content-data"></div>
						</div>
					</div>
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<!-- Footer opened -->
			<div class="main-footer ht-40">
				<div class="container-fluid pd-t-0-f ht-100p">
					<span>Copyright © 2020 <a href="#">Valex</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span>
				</div>
			</div>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<script>
			$(document).ready(function() {
				var tableone = $('#exampleone').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'New Order',
							nextStatus : 'In Production'
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="11">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9,10] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "10%" }]
				} );

				var tabletwo = $('#exampletwo').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'In Production',
							nextStatus : 'Ready'
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="11">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9,10] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "10%" }]
				} );

				var tablethree = $('#examplethree').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'Ready',
							nextStatus : 'Out for Delivery'
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="11">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9,10] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "10%" }]
				} );

				var tablefour = $('#examplefour').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'Out for Delivery',
							nextStatus : 'Delivered'
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="11">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9,10] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "10%" }]
				} );

				var tablefive = $('#examplefive').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'Delivered',
							nextStatus : ''
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="10">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" }]
				} );

				var tablesix = $('#examplesix').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'On Hold',
							nextStatus : ''
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="10">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" }]
				} );

				var tableseven = $('#exampleseven').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : 'Cancelled',
							nextStatus : ''
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="10">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" }]
				} );

				var tableeight = $('#exampleeight').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"iDisplayLength"	:	100,
					"sDom": 'Brtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"ajax": {
						url  :"fetch.php",
						type : "POST",
						data : {
							status : '',
							nextStatus : ''
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" )
						{
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] != "Sharaf DG" )
						{
							$('td', row).css('background-color', 'white');
						}
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="10">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,3,4,5,6,7,8,9] } ],
					"aoColumns": [{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "15%" }, { "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "3%" }]
				} );

				$('#orderSearchText').keyup(function(){
					tableone.search($(this).val()).column(0).draw() ;
					tabletwo.search($(this).val()).column(0).draw() ;
					tablethree.search($(this).val()).column(0).draw() ;
					tablefour.search($(this).val()).column(0).draw() ;
					tablefive.search($(this).val()).column(0).draw() ;
					tablesix.search($(this).val()).column(0).draw() ;
					tableseven.search($(this).val()).column(0).draw() ;
					tableeight.search($(this).val()).column(0).draw() ;
				});

			} );

			//Image Modal
			$(document).on('click','#tableImage',function(event){
				event.preventDefault();
				var per_id=$(this).data('id');
				$('#content-data').html('');
				$.ajax({
					url:'modalImage.php',
					type:'POST',
					data:'id='+per_id,
					dataType:'html'
				}).done(function(data){
					$('#content-data').html('');
					$('#content-data').html(data);
				}).fail(function(){
					$('#content-data').html('<p>Error</p>');
				});
        	});

			//Change Status
			$(document).on('click','#statusChangeNext',function(event){
				if(confirm("Are you sure changing status?")){
					event.preventDefault();
					var id = $(this).attr('data-id');
					$.ajax({
						url     : 'statusChange.php',
						method  : 'POST',
						data    : {id : id},
						success : function(data)
						{
							$('#exampleone').DataTable().ajax.reload();
							$('#exampletwo').DataTable().ajax.reload();
							$('#examplethree').DataTable().ajax.reload();
							$('#examplefour').DataTable().ajax.reload();
							$('#examplefive').DataTable().ajax.reload();
							$('#examplesix').DataTable().ajax.reload();
							$('#exampleseven').DataTable().ajax.reload();
							$('#exampleeight').DataTable().ajax.reload();
						}
					});
				}
				else{
					return false;
				}
			});

			$(document).ready(function(){

			});
		</script>

		<!-- JQuery min js -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Ionicons js -->
		<script src="assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>

		<!-- Internal Data tables -->
		<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatable/js/responsive.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/js/jquery.dataTables.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="assets/plugins/datatable/js/pdfmake.min.js"></script>
		<script src="assets/plugins/datatable/js/vfs_fonts.js"></script>
		<script src="assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatable/js/responsive.bootstrap4.min.js"></script>

		<!--Internal  Datatable js -->
		<script src="assets/js/table-data.js"></script>

		<!-- Internal Select2 js-->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Internal Input tags js-->
		<script src="assets/plugins/inputtags/inputtags.js"></script>

		<!-- P-scroll js
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script> -->

		<!-- eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>

		<!--- Tabs JS-->
		<script src="assets/plugins/tabs/jquery.multipurpose_tabcontent.js"></script>
		<script src="assets/js/tabs.js"></script>

		<!-- Rating js-->
		<script src="assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="assets/plugins/rating/jquery.barrating.js"></script>

		<!-- Custom Scroll bar Js-->
		<script src="assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- Horizontalmenu js-->
		<script src="assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

		<!-- Sticky js -->
		<script src="assets/js/sticky.js"></script>

		<!-- Internal Select2.min js -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Right-sidebar js -->
		<!-- <script src="assets/plugins/sidebar/sidebar.js"></script>
		<script src="assets/plugins/sidebar/sidebar-custom.js"></script> -->

		<!-- Internal Modal js-->
		<script src="assets/js/modal.js"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
	</body>
</html>