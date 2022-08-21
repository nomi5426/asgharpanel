<?php
// session_start();
include "../base/db.php";
include '../base/deliveryNoteDownload.php';

if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) && (!isset($_SESSION['_factoryLogin'])) && (!isset($_SESSION['_staffLogin'])) && (!isset($_SESSION['_deliveryLogin']))){ 
  header("Location:../index.php");
}

//GET USER DETAILS
if( (isset($_SESSION['_superAdminLogin'])) || (isset($_SESSION['_adminLogin'])) || (isset($_SESSION['_salesLogin'])) || (isset($_SESSION['_factoryLogin'])) || (isset($_SESSION['_staffLogin'])) || (isset($_SESSION['_deliveryLogin'])) ){
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
}
?>
	<!-- Loader -->
	<div id="global-loader">
		<img src="../assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- /Loader -->			
	<!-- main-header opened -->
	<div class="main-header nav nav-item hor-header top-header">
		<div class="container">
			<div class="main-header-left ">
				<a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a>
				<a class="header-brand">
					<img src="../assets/img/brand/logo-white.png" class="desktop-dark">
					<img src="../assets/img/brand/logo.png" href="index.php" class="desktop-logo">
					<img src="../assets/img/brand/favicon.png" class="desktop-logo-1">
					<img src="../assets/img/brand/favicon-white.png" class="desktop-logo-dark">
				</a>
				<a class="header-brand header-brand2 d-none d-lg-block">
					<img src="../assets/img/brand/logo-white.png" class="desktop-dark">
					<img src="../assets/img/brand/logo.png" href="index.php" class="desktop-logo">
					<img src="../assets/img/brand/favicon.png" href="index.php" class="desktop-logo-1">
					<img src="../assets/img/brand/favicon-white.png" class="desktop-logo-dark">
				</a>
				<div class="main-header-center  ml-4">
					<input class="form-control" placeholder="Search for Order.." type="text" id="orderSearchText"><button class="btn"><i class="fe fe-search"></i></button>
				</div>
			</div><!-- search -->
			<div class="main-header-right">
				<div class="nav nav-item  navbar-nav-right ml-auto">
					<div class="nav-item full-screen fullscreen-button">
						<a class="new nav-link full-screen-link"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
					</div>
					<div class="dropdown main-profile-menu nav nav-item nav-link">
						<a class="profile-user d-flex" href=""><img alt="" src="../assets/img/faces/usericon.png"></a>
						<div class="dropdown-menu">
							<div class="main-header-profile bg-primary p-3">
								<div class="d-flex wd-100p">
									<div class="main-img-user"><img alt="" src="../assets/img/faces/usericon-inner.png" class=""></div>
									<div class="ml-3 my-auto">
										<h6><?php echo $firstName ?></h6><span><?php echo $userrole ?></span>
									</div>
								</div>
							</div>
							<a class="dropdown-item" href="../base/logout.php"><i class="bx bx-log-out"></i> Sign Out</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /main-header -->

	<!--Horizontal-main -->
	<div class="sticky">
		<div class="horizontal-main hor-menu clearfix side-header">
			<div class="horizontal-mainwrapper container clearfix">
				<!--SUPER ADMIN USER-->
				<?php if($userrole == "superadmin"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
							<li aria-haspopup="true"><a href="../order/approve_order.php" class=""><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M22,5.18L10.59,16.6l-4.24-4.24l1.41-1.41l2.83,2.83l10-10L22,5.18z M19.79,10.22C19.92,10.79,20,11.39,20,12 c0,4.42-3.58,8-8,8s-8-3.58-8-8c0-4.42,3.58-8,8-8c1.58,0,3.04,0.46,4.28,1.25l1.44-1.44C16.1,2.67,14.13,2,12,2C6.48,2,2,6.48,2,12 c0,5.52,4.48,10,10,10s10-4.48,10-10c0-1.19-0.22-2.33-0.6-3.39L19.79,10.22z"/></svg> To be Approved</a></li>
							<li aria-haspopup="true"><a href="../base/superadmin.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 19h14V5H5v14zm6-12h6v2h-6V7zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z" opacity=".3"/><path d="M11 7h6v2h-6zm0 4h6v2h-6zm0 4h6v2h-6zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zM20.1 3H3.9c-.5 0-.9.4-.9.9v16.2c0 .4.4.9.9.9h16.2c.4 0 .9-.5.9-.9V3.9c0-.5-.5-.9-.9-.9zM19 19H5V5h14v14z"/></svg> Order Status<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
									<li aria-haspopup="true"><a href="../order/new_order.php" class="slide-item"> New Order</a></li>
									<li aria-haspopup="true"><a href="../order/in_production.php" class="slide-item">In Production</a></li>
									<li aria-haspopup="true"><a href="../order/ready.php" class="slide-item">Ready</a></li>
									<li aria-haspopup="true"><a href="../order/out_for_delivery.php" class="slide-item">Out For Delivery</a></li>
									<li aria-haspopup="true"><a href="../order/delivered.php" class="slide-item">Delivered</a></li>
									<li aria-haspopup="true"><a href="../order/on_hold.php" class="slide-item">On Hold</a></li>
									<li aria-haspopup="true"><a href="../order/cancelled.php" class="slide-item">Cancelled</a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../order/advanced_search.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 5h10v2H3zm4 6H3v2h4v2h2V9H7zm6 4h-2v6h2v-2h8v-2h-8zM3 17h6v2H3zm8-6h10v2H11zm6-8h-2v6h2V7h4V5h-4z"/></svg> Advance Sorting<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Asghar Furniture</b></a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Sharjah</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Ajman</a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>The Furniture Store</b></a></li>
                                    <li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Sharaf</b></a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Amazon</b></a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>NooN</b></a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../delivery/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4.25 12.15L11 13V7h1.5v5.25l4.5 2.67-.75 1.23z" opacity=".3"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Delivery Schedule</a>
							<li aria-haspopup="true"><a href="../category/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><circle cx="17.5" cy="17.5" opacity=".3" r="2.5"/><path d="M5 15.5h4v4H5zm7-9.66L10.07 9h3.86z" opacity=".3"/><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM11 13.5H3v8h8v-8zm-2 6H5v-4h4v4z"/></svg> Product Category</a>
							<li aria-haspopup="true"><a href="../staff/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 13H3.2L5 10.9V10H2v1h1.8L2 13.1v.9h3zm2-8h14v2H7zM5 16H2v1h2v.5H3v1h1v.5H2v1h3zm2 1h14v2H7zM3 8h1V4H2v1h1zm4 3h14v2H7z"/></svg> Staff Listing</a>
							<li aria-haspopup="true"><a href="../qrprint/index.php"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><path d="M15,21h-2v-2h2V21z M13,14h-2v5h2V14z M21,12h-2v4h2V12z M19,10h-2v2h2V10z M7,12H5v2h2V12z M5,10H3v2h2V10z M12,5h2V3h-2V5 z M4.5,4.5v3h3v-3H4.5z M9,9H3V3h6V9z M4.5,16.5v3h3v-3H4.5z M9,21H3v-6h6V21z M16.5,4.5v3h3v-3H16.5z M21,9h-6V3h6V9z M19,19v-3 l-4,0v2h2v3h4v-2H19z M17,12l-4,0v2h4V12z M13,10H7v2h2v2h2v-2h2V10z M14,9V7h-2V5h-2v4L14,9z M6.75,5.25h-1.5v1.5h1.5V5.25z M6.75,17.25h-1.5v1.5h1.5V17.25z M18.75,5.25h-1.5v1.5h1.5V5.25z"/></svg> View QR</a>
							<li aria-haspopup="true"><a href="../agreement/index.php"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z" opacity=".3"/><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z M21.83,13.07c1.56-1.56,1.56-4.09,0-5.66l-4.24-4.24c-1.56-1.56-4.09-1.56-5.66,0 l-0.28,0.28l-0.28-0.28c-1.56-1.56-4.09-1.56-5.66,0L2.17,6.71c-1.42,1.42-1.55,3.63-0.4,5.19l1.45-1.45 C2.83,9.7,2.96,8.75,3.59,8.12l3.54-3.54c0.78-0.78,2.05-0.78,2.83,0l3.56,3.56c0.18,0.18,0.21,0.5,0,0.71 c-0.21,0.21-0.53,0.18-0.71,0L9.52,5.57l-5.8,5.79c-0.98,0.97-0.98,2.56,0,3.54c0.39,0.39,0.89,0.63,1.42,0.7 c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7 c0.07,0.54,0.31,1.03,0.7,1.42c0.47,0.47,1.1,0.73,1.77,0.73c0.67,0,1.3-0.26,1.77-0.73L21.83,13.07z"/></g></svg> Sales Agreement</a>
							<li aria-haspopup="true"><a href="../customer/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M11 12q-1.65 0-2.825-1.175Q7 9.65 7 8q0-1.65 1.175-2.825Q9.35 4 11 4q1.65 0 2.825 1.175Q15 6.35 15 8q0 1.65-1.175 2.825Q12.65 12 11 12Zm0-2q.825 0 1.413-.588Q13 8.825 13 8t-.587-1.412Q11.825 6 11 6q-.825 0-1.412.588Q9 7.175 9 8t.588 1.412Q10.175 10 11 10Zm11.1 13.5-3.2-3.2q-.525.3-1.125.5T16.5 21q-1.875 0-3.188-1.312Q12 18.375 12 16.5q0-1.875 1.312-3.188Q14.625 12 16.5 12q1.875 0 3.188 1.312Q21 14.625 21 16.5q0 .675-.2 1.275-.2.6-.5 1.125l3.2 3.2ZM16.5 19q1.05 0 1.775-.725Q19 17.55 19 16.5q0-1.05-.725-1.775Q17.55 14 16.5 14q-1.05 0-1.775.725Q14 15.45 14 16.5q0 1.05.725 1.775Q15.45 19 16.5 19ZM3 20v-2.775q0-.85.425-1.575t1.175-1.1q1.275-.65 2.875-1.1 1.6-.45 3.55-.45-.3.45-.512.962-.213.513-.338 1.063-1.5.125-2.675.512-1.175.388-1.975.813-.25.125-.387.362Q5 16.95 5 17.225V18h5.175q.125.55.338 1.05.212.5.512.95Zm8-12Zm-.825 10Z"/></svg> Customer Search</a>
						</ul>
					</nav>
				<?php }?>
				<!--ADMIN USER-->
				<?php if($userrole == "admin"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
						<li aria-haspopup="true"><a href="../order/approve_order.php" class=""><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M22,5.18L10.59,16.6l-4.24-4.24l1.41-1.41l2.83,2.83l10-10L22,5.18z M19.79,10.22C19.92,10.79,20,11.39,20,12 c0,4.42-3.58,8-8,8s-8-3.58-8-8c0-4.42,3.58-8,8-8c1.58,0,3.04,0.46,4.28,1.25l1.44-1.44C16.1,2.67,14.13,2,12,2C6.48,2,2,6.48,2,12 c0,5.52,4.48,10,10,10s10-4.48,10-10c0-1.19-0.22-2.33-0.6-3.39L19.79,10.22z"/></svg> To be Approved</a></li>
							<li aria-haspopup="true"><a href="../base/admin.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 19h14V5H5v14zm6-12h6v2h-6V7zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z" opacity=".3"/><path d="M11 7h6v2h-6zm0 4h6v2h-6zm0 4h6v2h-6zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zM20.1 3H3.9c-.5 0-.9.4-.9.9v16.2c0 .4.4.9.9.9h16.2c.4 0 .9-.5.9-.9V3.9c0-.5-.5-.9-.9-.9zM19 19H5V5h14v14z"/></svg> Order Status<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
									<li aria-haspopup="true"><a href="../order/new_order.php" class="slide-item"> New Order</a></li>
									<li aria-haspopup="true"><a href="../order/in_production.php" class="slide-item">In Production</a></li>
									<li aria-haspopup="true"><a href="../order/ready.php" class="slide-item">Ready</a></li>
									<li aria-haspopup="true"><a href="../order/out_for_delivery.php" class="slide-item">Out For Delivery</a></li>
									<li aria-haspopup="true"><a href="../order/delivered.php" class="slide-item">Delivered</a></li>
									<li aria-haspopup="true"><a href="../order/on_hold.php" class="slide-item">On Hold</a></li>
									<li aria-haspopup="true"><a href="../order/cancelled.php" class="slide-item">Cancelled</a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../order/advanced_search.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 5h10v2H3zm4 6H3v2h4v2h2V9H7zm6 4h-2v6h2v-2h8v-2h-8zM3 17h6v2H3zm8-6h10v2H11zm6-8h-2v6h2V7h4V5h-4z"/></svg> Advance Sorting<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Asghar Furniture</b></a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Sharjah</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Ajman</a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>The Furniture Store</b></a></li>
                                    <li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Sharaf</b></a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Amazon</b></a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>NooN</b></a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../delivery/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4.25 12.15L11 13V7h1.5v5.25l4.5 2.67-.75 1.23z" opacity=".3"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Delivery Schedule</a>
							<li aria-haspopup="true"><a href="../agreement/index.php"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z" opacity=".3"/><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z M21.83,13.07c1.56-1.56,1.56-4.09,0-5.66l-4.24-4.24c-1.56-1.56-4.09-1.56-5.66,0 l-0.28,0.28l-0.28-0.28c-1.56-1.56-4.09-1.56-5.66,0L2.17,6.71c-1.42,1.42-1.55,3.63-0.4,5.19l1.45-1.45 C2.83,9.7,2.96,8.75,3.59,8.12l3.54-3.54c0.78-0.78,2.05-0.78,2.83,0l3.56,3.56c0.18,0.18,0.21,0.5,0,0.71 c-0.21,0.21-0.53,0.18-0.71,0L9.52,5.57l-5.8,5.79c-0.98,0.97-0.98,2.56,0,3.54c0.39,0.39,0.89,0.63,1.42,0.7 c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7 c0.07,0.54,0.31,1.03,0.7,1.42c0.47,0.47,1.1,0.73,1.77,0.73c0.67,0,1.3-0.26,1.77-0.73L21.83,13.07z"/></g></svg> Sales Agreement</a>
							<li aria-haspopup="true"><a href="../customer/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M11 12q-1.65 0-2.825-1.175Q7 9.65 7 8q0-1.65 1.175-2.825Q9.35 4 11 4q1.65 0 2.825 1.175Q15 6.35 15 8q0 1.65-1.175 2.825Q12.65 12 11 12Zm0-2q.825 0 1.413-.588Q13 8.825 13 8t-.587-1.412Q11.825 6 11 6q-.825 0-1.412.588Q9 7.175 9 8t.588 1.412Q10.175 10 11 10Zm11.1 13.5-3.2-3.2q-.525.3-1.125.5T16.5 21q-1.875 0-3.188-1.312Q12 18.375 12 16.5q0-1.875 1.312-3.188Q14.625 12 16.5 12q1.875 0 3.188 1.312Q21 14.625 21 16.5q0 .675-.2 1.275-.2.6-.5 1.125l3.2 3.2ZM16.5 19q1.05 0 1.775-.725Q19 17.55 19 16.5q0-1.05-.725-1.775Q17.55 14 16.5 14q-1.05 0-1.775.725Q14 15.45 14 16.5q0 1.05.725 1.775Q15.45 19 16.5 19ZM3 20v-2.775q0-.85.425-1.575t1.175-1.1q1.275-.65 2.875-1.1 1.6-.45 3.55-.45-.3.45-.512.962-.213.513-.338 1.063-1.5.125-2.675.512-1.175.388-1.975.813-.25.125-.387.362Q5 16.95 5 17.225V18h5.175q.125.55.338 1.05.212.5.512.95Zm8-12Zm-.825 10Z"/></svg> Customer Search</a>
						</ul>
					</nav>
				<?php }?>
				<!--IF USER IS SALES-->
				<?php if($userrole == "sales"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
							<li aria-haspopup="true"><a href="../order/approve_order.php" class=""><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><rect fill="none" height="24" width="24"/><path d="M22,5.18L10.59,16.6l-4.24-4.24l1.41-1.41l2.83,2.83l10-10L22,5.18z M19.79,10.22C19.92,10.79,20,11.39,20,12 c0,4.42-3.58,8-8,8s-8-3.58-8-8c0-4.42,3.58-8,8-8c1.58,0,3.04,0.46,4.28,1.25l1.44-1.44C16.1,2.67,14.13,2,12,2C6.48,2,2,6.48,2,12 c0,5.52,4.48,10,10,10s10-4.48,10-10c0-1.19-0.22-2.33-0.6-3.39L19.79,10.22z"/></svg> To be Approved</a></li>
							<li aria-haspopup="true"><a href="../base/sales.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 19h14V5H5v14zm6-12h6v2h-6V7zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z" opacity=".3"/><path d="M11 7h6v2h-6zm0 4h6v2h-6zm0 4h6v2h-6zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zM20.1 3H3.9c-.5 0-.9.4-.9.9v16.2c0 .4.4.9.9.9h16.2c.4 0 .9-.5.9-.9V3.9c0-.5-.5-.9-.9-.9zM19 19H5V5h14v14z"/></svg> Order Status<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
									<li aria-haspopup="true"><a href="../order/new_order.php" class="slide-item"> New Order</a></li>
									<li aria-haspopup="true"><a href="../order/in_production.php" class="slide-item">In Production</a></li>
									<li aria-haspopup="true"><a href="../order/ready.php" class="slide-item">Ready</a></li>
									<li aria-haspopup="true"><a href="../order/out_for_delivery.php" class="slide-item">Out For Delivery</a></li>
									<li aria-haspopup="true"><a href="../order/delivered.php" class="slide-item">Delivered</a></li>
									<li aria-haspopup="true"><a href="../order/on_hold.php" class="slide-item">On Hold</a></li>
									<li aria-haspopup="true"><a href="../order/cancelled.php" class="slide-item">Cancelled</a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../order/advanced_search.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 5h10v2H3zm4 6H3v2h4v2h2V9H7zm6 4h-2v6h2v-2h8v-2h-8zM3 17h6v2H3zm8-6h10v2H11zm6-8h-2v6h2V7h4V5h-4z"/></svg> Advance Sorting<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Asghar Furniture</b></a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Sharjah</a></li>
									<li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Ajman</a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>The Furniture Store</b></a></li>
                                    <li aria-haspopup="false"><a href="../order/advanced_search.php" class="sub-menu-sub">Dubai</a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Sharaf</b></a></li>
                                    <li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>Amazon</b></a></li>
									<li aria-haspopup="true"><a href="../order/advanced_search.php" class="slide-item"><b>NooN</b></a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../delivery/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4.25 12.15L11 13V7h1.5v5.25l4.5 2.67-.75 1.23z" opacity=".3"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Delivery Schedule</a>
							<li aria-haspopup="true"><a href="../agreement/index.php"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z" opacity=".3"/><path d="M12.22,19.85c-0.18,0.18-0.5,0.21-0.71,0c-0.18-0.18-0.21-0.5,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39 c-0.19,0.2-0.51,0.19-0.71,0c-0.21-0.21-0.18-0.53,0-0.71l3.39-3.39l-1.41-1.41l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0 c-0.19-0.19-0.19-0.51,0-0.71l3.39-3.39L9.24,10.1l-3.39,3.39c-0.18,0.18-0.5,0.21-0.71,0c-0.19-0.2-0.19-0.51,0-0.71L9.52,8.4 l1.87,1.86c0.95,0.95,2.59,0.94,3.54,0c0.98-0.98,0.98-2.56,0-3.54l-1.86-1.86l0.28-0.28c0.78-0.78,2.05-0.78,2.83,0l4.24,4.24 c0.78,0.78,0.78,2.05,0,2.83L12.22,19.85z M21.83,13.07c1.56-1.56,1.56-4.09,0-5.66l-4.24-4.24c-1.56-1.56-4.09-1.56-5.66,0 l-0.28,0.28l-0.28-0.28c-1.56-1.56-4.09-1.56-5.66,0L2.17,6.71c-1.42,1.42-1.55,3.63-0.4,5.19l1.45-1.45 C2.83,9.7,2.96,8.75,3.59,8.12l3.54-3.54c0.78-0.78,2.05-0.78,2.83,0l3.56,3.56c0.18,0.18,0.21,0.5,0,0.71 c-0.21,0.21-0.53,0.18-0.71,0L9.52,5.57l-5.8,5.79c-0.98,0.97-0.98,2.56,0,3.54c0.39,0.39,0.89,0.63,1.42,0.7 c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7c0.07,0.52,0.3,1.02,0.7,1.42c0.4,0.4,0.9,0.63,1.42,0.7 c0.07,0.54,0.31,1.03,0.7,1.42c0.47,0.47,1.1,0.73,1.77,0.73c0.67,0,1.3-0.26,1.77-0.73L21.83,13.07z"/></g></svg> Sales Agreement</a>
							<li aria-haspopup="true"><a href="../customer/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M11 12q-1.65 0-2.825-1.175Q7 9.65 7 8q0-1.65 1.175-2.825Q9.35 4 11 4q1.65 0 2.825 1.175Q15 6.35 15 8q0 1.65-1.175 2.825Q12.65 12 11 12Zm0-2q.825 0 1.413-.588Q13 8.825 13 8t-.587-1.412Q11.825 6 11 6q-.825 0-1.412.588Q9 7.175 9 8t.588 1.412Q10.175 10 11 10Zm11.1 13.5-3.2-3.2q-.525.3-1.125.5T16.5 21q-1.875 0-3.188-1.312Q12 18.375 12 16.5q0-1.875 1.312-3.188Q14.625 12 16.5 12q1.875 0 3.188 1.312Q21 14.625 21 16.5q0 .675-.2 1.275-.2.6-.5 1.125l3.2 3.2ZM16.5 19q1.05 0 1.775-.725Q19 17.55 19 16.5q0-1.05-.725-1.775Q17.55 14 16.5 14q-1.05 0-1.775.725Q14 15.45 14 16.5q0 1.05.725 1.775Q15.45 19 16.5 19ZM3 20v-2.775q0-.85.425-1.575t1.175-1.1q1.275-.65 2.875-1.1 1.6-.45 3.55-.45-.3.45-.512.962-.213.513-.338 1.063-1.5.125-2.675.512-1.175.388-1.975.813-.25.125-.387.362Q5 16.95 5 17.225V18h5.175q.125.55.338 1.05.212.5.512.95Zm8-12Zm-.825 10Z"/></svg> Customer Search</a>

						</ul>
					</nav>
				<?php }?>
				<!--FACTORY USER-->
				<?php if($userrole == "factory"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
							<li aria-haspopup="true"><a href="../base/factory.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 19h14V5H5v14zm6-12h6v2h-6V7zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z" opacity=".3"/><path d="M11 7h6v2h-6zm0 4h6v2h-6zm0 4h6v2h-6zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zM20.1 3H3.9c-.5 0-.9.4-.9.9v16.2c0 .4.4.9.9.9h16.2c.4 0 .9-.5.9-.9V3.9c0-.5-.5-.9-.9-.9zM19 19H5V5h14v14z"/></svg> Order Status<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
									<li aria-haspopup="true"><a href="../order/new_order.php" class="slide-item"> New Order</a></li>
									<li aria-haspopup="true"><a href="../order/in_production.php" class="slide-item">In Production</a></li>
									<li aria-haspopup="true"><a href="../order/ready.php" class="slide-item">Ready</a></li>
									<li aria-haspopup="true"><a href="../order/out_for_delivery.php" class="slide-item">Out For Delivery</a></li>
									<li aria-haspopup="true"><a href="../order/delivered.php" class="slide-item">Delivered</a></li>
									<li aria-haspopup="true"><a href="../order/on_hold.php" class="slide-item">On Hold</a></li>
									<li aria-haspopup="true"><a href="../order/cancelled.php" class="slide-item">Cancelled</a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../delivery/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4.25 12.15L11 13V7h1.5v5.25l4.5 2.67-.75 1.23z" opacity=".3"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Delivery Schedule</a>
							<li aria-haspopup="true"><a href="../qrprint/index.php"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><path d="M15,21h-2v-2h2V21z M13,14h-2v5h2V14z M21,12h-2v4h2V12z M19,10h-2v2h2V10z M7,12H5v2h2V12z M5,10H3v2h2V10z M12,5h2V3h-2V5 z M4.5,4.5v3h3v-3H4.5z M9,9H3V3h6V9z M4.5,16.5v3h3v-3H4.5z M9,21H3v-6h6V21z M16.5,4.5v3h3v-3H16.5z M21,9h-6V3h6V9z M19,19v-3 l-4,0v2h2v3h4v-2H19z M17,12l-4,0v2h4V12z M13,10H7v2h2v2h2v-2h2V10z M14,9V7h-2V5h-2v4L14,9z M6.75,5.25h-1.5v1.5h1.5V5.25z M6.75,17.25h-1.5v1.5h1.5V17.25z M18.75,5.25h-1.5v1.5h1.5V5.25z"/></svg> View QR</a>
							<li aria-haspopup="true"><a href="../customer/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M11 12q-1.65 0-2.825-1.175Q7 9.65 7 8q0-1.65 1.175-2.825Q9.35 4 11 4q1.65 0 2.825 1.175Q15 6.35 15 8q0 1.65-1.175 2.825Q12.65 12 11 12Zm0-2q.825 0 1.413-.588Q13 8.825 13 8t-.587-1.412Q11.825 6 11 6q-.825 0-1.412.588Q9 7.175 9 8t.588 1.412Q10.175 10 11 10Zm11.1 13.5-3.2-3.2q-.525.3-1.125.5T16.5 21q-1.875 0-3.188-1.312Q12 18.375 12 16.5q0-1.875 1.312-3.188Q14.625 12 16.5 12q1.875 0 3.188 1.312Q21 14.625 21 16.5q0 .675-.2 1.275-.2.6-.5 1.125l3.2 3.2ZM16.5 19q1.05 0 1.775-.725Q19 17.55 19 16.5q0-1.05-.725-1.775Q17.55 14 16.5 14q-1.05 0-1.775.725Q14 15.45 14 16.5q0 1.05.725 1.775Q15.45 19 16.5 19ZM3 20v-2.775q0-.85.425-1.575t1.175-1.1q1.275-.65 2.875-1.1 1.6-.45 3.55-.45-.3.45-.512.962-.213.513-.338 1.063-1.5.125-2.675.512-1.175.388-1.975.813-.25.125-.387.362Q5 16.95 5 17.225V18h5.175q.125.55.338 1.05.212.5.512.95Zm8-12Zm-.825 10Z"/></svg> Customer Search</a>
						</ul>
					</nav>
				<?php }?>
				<!--IF USER IS STAFF-->
				<?php if($userrole == "staff"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
							<li aria-haspopup="true"><a href="../base/staff.php" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 19h14V5H5v14zm6-12h6v2h-6V7zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2zm0 4h2v2H7v-2z" opacity=".3"/><path d="M11 7h6v2h-6zm0 4h6v2h-6zm0 4h6v2h-6zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zM20.1 3H3.9c-.5 0-.9.4-.9.9v16.2c0 .4.4.9.9.9h16.2c.4 0 .9-.5.9-.9V3.9c0-.5-.5-.9-.9-.9zM19 19H5V5h14v14z"/></svg> Order Status<i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">
									<li aria-haspopup="true"><a href="../order/new_order.php" class="slide-item"> New Order</a></li>
									<li aria-haspopup="true"><a href="../order/in_production.php" class="slide-item">In Production</a></li>
								</ul>
							</li>
							<li aria-haspopup="true"><a href="../delivery/index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4.25 12.15L11 13V7h1.5v5.25l4.5 2.67-.75 1.23z" opacity=".3"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg> Delivery Schedule</a>
						</ul>
					</nav>
				<?php }?>
				<!--IF USER IS DELIVERY-->
				<?php if($userrole == "delivery"){?>
					<!--Nav-->
					<nav class="horizontalMenu clearfix">
						<ul class="horizontalMenu-list">
						</ul>
					</nav>
				<?php }?>
			</div>
		</div>
	</div>
	<!--Horizontal-main -->
	<script type="text/javascript">

	</script>

