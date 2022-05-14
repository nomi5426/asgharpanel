<?php
	session_start();
	include "base/db.php";
	if (!empty( $_SESSION['_superAdminLogin'] ) ) {
		header('Location: base/superadmin.php');
		exit;
	}
	if (!empty( $_SESSION['_adminLogin'] ) ) {
		header('Location: base/admin.php');
		exit;
	}
	else if (!empty($_SESSION['_salesLogin'])){
		header('Location: base/sales.php');
		exit;
	}else if (!empty($_SESSION['_factoryLogin'])){
		header('Location: base/factory.php');
		exit;
	}
	else if (!empty($_SESSION['_staffLogin'])){
		header('Location: base/staff.php');
		exit;
	}

	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = 'log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	} 

	if(isset($_POST['signin'])){
		$username=$_POST['username'];
		$pass=$_POST['pass'];

		// $admin="admin";
		// $user="user";

		$super_admin_sql="SELECT * FROM user where username='$username' AND pass='$pass' AND userrole='superadmin'";
		$super_admin_Query=mysqli_query($conn,$super_admin_sql);

		$admin_sql="SELECT * FROM user where username='$username' AND pass='$pass' AND userrole='admin'";
		$adminQuery=mysqli_query($conn,$admin_sql);

		$factory_sql="SELECT * FROM user where username='$username' AND pass='$pass' AND userrole='factory'";
		$factoryQuery=mysqli_query($conn,$factory_sql);
		
		$sales_sql="SELECT * FROM user where username='$username' AND pass='$pass' AND userrole='sales'";
		$salesQuery=mysqli_query($conn,$sales_sql);

		$staff_sql="SELECT * FROM user where username='$username' AND pass='$pass' AND userrole='staff'";
		$staffQuery=mysqli_query($conn,$staff_sql);

		//SUPERADMIN
		if(mysqli_num_rows($super_admin_Query)==1){
			if(!empty($_POST["remember"])){
				setcookie ("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
				setcookie ("pass", $_POST["pass"], time() + (10 * 365 * 24 * 60 * 60));
			}
			else{
				if(isset($_COOKIE["username"])){
					setcookie ("username", "");
				}
				if(isset($_COOKIE["pass"])){
					setcookie ("pass", "");
				}
			}
			if (!session_id()) session_start();
			$_SESSION['_superAdminLogin'] = $username;
			$_SESSION['userName'] = $username;
			//SESSION MANAGEMENT
			$_SESSION['expire'] = time();
			//LOG
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Sales User '".$username."' Logged In Successfully");			
			header('Location: base/superadmin.php');
			die();
		}

		//ADMIN
		else if(mysqli_num_rows($adminQuery)==1){
			if(!empty($_POST["remember"])){
				setcookie ("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
				setcookie ("pass", $_POST["pass"], time() + (10 * 365 * 24 * 60 * 60));
			}
			else{
				if(isset($_COOKIE["username"])){
					setcookie ("username", "");
				}
				if(isset($_COOKIE["pass"])){
					setcookie ("pass", "");
				}
			}
			if (!session_id()) session_start();
			$_SESSION['_adminLogin'] = $username;
			$_SESSION['userName'] = $username;

			//Session Management
			$_SESSION['expire'] = time();

			//LOG
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Admin User '".$username."' Logged In Successfully");

			$successMsg = 'User logged in successfully';
			header('Location: base/admin.php');
			die();
		}

		//SALES
		else if(mysqli_num_rows($salesQuery)==1){
			if(!empty($_POST["remember"])){
				setcookie ("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
				setcookie ("pass", $_POST["pass"], time() + (10 * 365 * 24 * 60 * 60));
			}
			else{
				if(isset($_COOKIE["username"])){
					setcookie ("username", "");
				}
				if(isset($_COOKIE["pass"])){
					setcookie ("pass", "");
				}
			}
			if (!session_id()) session_start();
			$_SESSION['_salesLogin'] = $username;
			$_SESSION['userName'] = $username;
			//SESSION MANAGEMENT
			$_SESSION['expire'] = time();
			//LOG
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Factory User '".$username."' Logged In Successfully");
			header('Location: base/sales.php');
			die();
		}

		//FACTORY
		else if(mysqli_num_rows($factoryQuery)==1){
			if(!empty($_POST["remember"])){
				setcookie ("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
				setcookie ("pass", $_POST["pass"], time() + (10 * 365 * 24 * 60 * 60));
			}
			else{
				if(isset($_COOKIE["username"])){
					setcookie ("username", "");
				}
				if(isset($_COOKIE["pass"])){
					setcookie ("pass", "");
				}
			}
			if (!session_id()) session_start();
			$_SESSION['_factoryLogin'] = $username;
			$_SESSION['userName'] = $username;
			//SESSION MANAGEMENT
			$_SESSION['expire'] = time();
			//LOG
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : Factory User '".$username."' Logged In Successfully");
			header('Location: base/factory.php');
			die();
		}

		//STAFF
		else if(mysqli_num_rows($staffQuery)==1){
			if(!empty($_POST["remember"])){
				setcookie ("username", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
				setcookie ("pass", $_POST["pass"], time() + (10 * 365 * 24 * 60 * 60));
			}
			else{
				if(isset($_COOKIE["username"])){
					setcookie ("username", "");
				}
				if(isset($_COOKIE["pass"])){
					setcookie ("pass", "");
				}
			}
			if (!session_id()) session_start();
			$_SESSION['_staffLogin'] = $username;
			$_SESSION['userName'] = $username;
			//SESSION MANAGEMENT
			$_SESSION['expire'] = time();
			//LOG
			date_default_timezone_set('Asia/Dubai');
			app_log("'".date('d-m-Y H:i:s')."' : STAFF User '".$username."' Logged In Successfully");			
			header('Location: base/staff.php');
			die();
		}		
		else {
			echo "<script>alert('Wrong User Name or Password, Please Try Again')</script>";
		}
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
		<title> Login - Order Management - Asghar Furniture LLC </title>
		<!-- Favicon -->
		<link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>
		<!-- Icons css -->
		<link href="assets/css/icons.css" rel="stylesheet">
		<!--  Right-sidemenu css -->
		<link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<!-- P-scroll bar css-->
		<link href="assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />
		<!--  Left-Sidebar css -->
		<link rel="stylesheet" href="assets/css/sidemenu.css">
		<!--- Style css --->
		<link href="assets/css/style.css" rel="stylesheet">
		<!--- Dark-mode css --->
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<!---Skinmodes css-->
		<link href="assets/css/skin-modes.css" rel="stylesheet" />
		<!--- Animations css-->
		<link href="assets/css/animate.css" rel="stylesheet">
	</head>
	<body class="error-page1 main-body bg-light">
		<!-- Loader -->
		<div id="global-loader">
			<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		<!-- Page -->
		<div class="page">
			<div class="container-fluid">
				<div class="row no-gutter">
					<!-- The image half -->
					<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
						<div class="row wd-100p mx-auto text-center">
							<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
								<img src="assets/img/media/login.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
							</div>
						</div>
					</div>
					<!-- The content half -->
					<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
						<div class="login d-flex align-items-center py-2">
							<!-- Demo content-->
							<div class="container p-0">
								<div class="row">
									<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
										<div class="card-sigin">
											<div class="mb-5 d-flex"> <a href="index.html"><img src="assets/img/brand/logo.png" class="sign-favicon ht-40" alt="logo"></a></div>
											<div class="card-sigin">
												<div class="main-signup-header">
													<h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
													<form action="index.php" method="post">
														<div class="form-group">
															<label>Email</label> <input class="form-control" placeholder="Enter your email" type="text" name="username" value="<?php if(isset($_COOKIE["username"])) {echo $_COOKIE["username"];} ?>">
														</div>
														<div class="form-group">
															<label>Password</label> <input class="form-control" placeholder="Enter your password" name="pass" type="password" value="<?php if(isset($_COOKIE["pass"])) {echo $_COOKIE["pass"];}?>">
														</div>
														<div class="form-group mb-0 justify-content-end">
															<div class="checkbox">
																<div class="custom-checkbox custom-control">
																	<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-2">
																	<label for="checkbox-2" class="custom-control-label mt-1">Save me next time!</label>
																</div>
															</div>
														</div>
														<div class="form-group mb-0 mt-3 justify-content-end">
															<div>
																<input class="btn btn-main-primary btn-block" name="signin" type="submit" value="Login">
															</div>
														</div>
													</form>
													<div class="main-signin-footer mt-5">
														<p><a href="">Forgot password?</a></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- End -->
						</div>
					</div><!-- End -->
				</div>
			</div>
			
		</div>
		<!-- End Page -->

		<script>
			var refreshSn = function (){
				var time = 600000;
				setTimeout(function ()
				{
				$.ajax({
					url: 'sessionRefresh.php',
					cache: false,
					complete: function () {
						refreshSn();
					}
				});
				},time);
			};
		</script>

		<!-- JQuery min js -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap Bundle js -->
		<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Ionicons js -->
		<script src="assets/plugins/ionicons/ionicons.js"></script>
		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>
		<!-- eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>
		<!-- Rating js-->
		<script src="assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="assets/plugins/rating/jquery.barrating.js"></script>
		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
	</body>
</html>