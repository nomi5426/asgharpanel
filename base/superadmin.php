<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: SUPER ADMIN ROLE USER INTERFACE AND TABLES OF ALL STATUSES
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/********************************************************************************/
	
	//INCLUDE DIRECTORIES
	include "../base/db.php";
	include '../base/deliveryNoteDownload.php';

	//KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
	if(!isset($_SESSION['_superAdminLogin'])){
		date_default_timezone_set('Asia/Dubai'); 
		app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt SUPER ADMIN User");
		header('Location:../index.php');
	}

	/**
	 * MASTER METHOD FOR LOG TRACKING
	 * @PARAM {STRING}	MESSAGE
	 */
	function app_log($message){
		date_default_timezone_set('Asia/Dubai');
		$logfile = 'log/log_'.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "../header/header_css.php"; ?>
	</head>
	<body class="main-body">
		<div class="page">
			<?php include "../header/header.php";?>
			<div class="main-content horizontal-content">
				<div class="container">
					<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								<h4 class="content-title mb-0 my-auto">Order</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Manage Order</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="pr-1 mb-3 mb-xl-0">
								<button id="newCommentAdd" class="modal-effect btn btn-warning mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#newCommentModal" type="button"><i class="typcn typcn-message-typing"></i>New Comment</button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
								<button id="newOrderAdd" class="modal-effect btn btn-primary mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#newOrderModal" type="button"><i class="typcn typcn-document-add"></i>New Order</button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
							<button id="newZohoOrderAdd" class="modal-effect btn btn-primary mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#zohoModal" type="button"><i class="typcn typcn-document-add"></i>Zoho Order</button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
								<button id="orderEdit" class="modal-effect btn btn-teal mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#editOrderModal" type="button"><i class="typcn typcn-document-edit"></i>Edit Order</button>
							</div>
							<div class="pr-1 mb-3 mb-xl-0">
								<button id="changeStatus" class="modal-effect btn btn-teal mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#statusChangeModal" type="button"><i class="typcn typcn-document-edit"></i>Status Change</button>
							</div>
						</div>
					</div>
					<div class="row row-sm">
						<div class="col-xl-12">
							<div class="card mg-b-20">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<h4 class="card-title mg-b-0">View All Order</h4>
									</div>
									<p class="tx-12 tx-gray-500 mb-2">Orders from All Status</p>
								</div>
								<div class="card-body">
									<div class="panel panel-primary tabs-style-2">
										<div class=" tab-menu-heading">
											<div class="tabs-menu" id="tabId">
												<ul class="nav panel-tabs main-nav-line nav-justified" id="myTab">
													<li class="nav-item"><a href="#crm" class="nav-link active" data-toggle="tab">CRM</a></li>
													<li class="nav-item"><a href="#neworder" class="nav-link" data-toggle="tab">New Order</a></li>
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
												<div class="tab-pane active" id="crm">
													<div class="table-responsive">
														<table id="examplenine" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
																	<th class="border-bottom-0">Action</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="neworder">
													<div class="table-responsive">
														<table id="exampleone" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">IID</th>
																	<th class="border-bottom-0">DEL/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
																	<th class="border-bottom-0">Action</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
																	<th class="border-bottom-0">Action</th>
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
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">City</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Color</th>
																	<th class="border-bottom-0">QTY</th>
																	<th class="border-bottom-0">Note</th>
																	<th class="border-bottom-0">Consult</th>
																	<th class="border-bottom-0">Image</th>
																	<th class="border-bottom-0">Comment</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">Action</th>
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
				</div>
				<!-- Container closed -->
				<!-- MODALS OPEN -->
				<!-- NEW ORDER -->
				<div class="modal effect-scale show" id="newOrderModal">
					<div class="modal-dialog-new-order" role="document">
						<div id="add-order-content-data"></div>
					</div>
				</div>
				<!--ZOHO MODAL-->
				<div class="modal effect-scale show" id="zohoModal">
					<div class="modal-dialog-edit-order" role="document">
						<div id="add-zoho-order-content-data"></div>
					</div>
				</div>
				<!--IMAGE MODAL-->
				<div class="modal effect-scale show" id="imagemodalone">
					<div class="modal-dialog-new-order modal-dialog-centered" role="document">
						<div id="content-data"></div>
					</div>
				</div>
				<!--COMMENT MODAL-->
				<div class="modal effect-scale show" id="newCommentModal">
					<div class="modal-dialog" role="document">
						<div id="add-comment-content-data"></div>
					</div>
				</div>
				<!--EDIT ORDER MODAL-->
				<div class="modal effect-scale show" id="editOrderModal">
					<div class="modal-dialog-edit-order" role="document">
						<div id="edit-order-content-data"></div>
					</div>
				</div>
				<!-- MATERIAL LPO MODAL -->
				<div class="modal effect-scale show" id="materialLpoModal">
					<div class="modal-dialog" role="document">
						<div id="material-content-data"></div>
					</div>
				</div>
				<!--ORDERS MADE STAFF MODAL -->
				<div class="modal effect-scale show" id="orderStaffModal">
					<div class="modal-dialog" role="document">
						<div id="add-order-staff-content-data"></div>
					</div>
				</div>
				<!--MODAL CLOSED-->
				<!--COMMENT MODAL-->
				<div class="modal effect-scale show" id="statusChangeModal">
					<div class="modal-dialog" role="document">
						<div id="status-change-content-data"></div>
					</div>
				</div>
			</div>
			<!-- main-content closed -->
			<?php include "../footer/footer.php"; ?>
		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
		<!-- JQuery min js -->
		<script src="../assets/plugins/jquery/jquery.min.js"></script>
		<!--Internal  Datepicker js -->
		<script src="../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
		<!--Internal  jquery-simple-datetimepicker js -->
		<script src="../assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
		<!-- Ionicons js -->
		<script src="../assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>
		<!-- Bootstrap Bundle js -->
		<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!--Internal  Parsley.min js -->
		<script src="../assets/plugins/parsleyjs/parsley.min.js"></script>
		<!-- Internal Data tables -->
		<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
		<script src="../assets/plugins/datatable/js/responsive.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/jquery.dataTables.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
		<script src="../assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="../assets/plugins/datatable/js/pdfmake.min.js"></script>
		<script src="../assets/plugins/datatable/js/vfs_fonts.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
		<script src="../assets/plugins/datatable/js/responsive.bootstrap4.min.js"></script>
		<!--Internal  Datatable js -->
		<script src="../assets/js/table-data.js"></script>
		<!-- Horizontalmenu js-->
		<script src="../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
		<!-- Sticky js -->
		<script src="../assets/js/sticky.js"></script>
		<!-- Internal Select2 js-->
		<script src="../assets/plugins/select2/js/select2.min.js"></script>
		<!-- eva-icons js -->
		<script src="../assets/js/eva-icons.min.js"></script>
       	<!-- Internal Sumoselect js -->
	   	<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>
		<!-- Internal form-elements js -->
		<script src="../assets/js/form-elements.js"></script>
		<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>
		<!-- Internal Form-validation js -->
		<script src="../assets/js/form-validation.js"></script>
		<!-- Sweet-alert js  -->
		<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="../assets/js/sweet-alert.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {

				//NEW ORDER
				var tableone = $('#exampleone').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
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
						// if(data[14] !=	 null){
						// 	$('td', row).css('background-color', 'blue');
						// }
					},
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//IN PRODUCTION
				var tabletwo = $('#exampletwo').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//READY
				var tablethree = $('#examplethree').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
						type : "POST",
						data : {
							status : 'Ready',
							nextStatus : 'Out For Delivery'
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//OUT FOR DELIVERY
				var tablefour = $('#examplefour').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
						type : "POST",
						data : {
							status : 'Out For Delivery',
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//DELIVERED
				var tablefive = $('#examplefive').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
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
									'<tr class="group"><td class="delback"colspan="12">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" }]
				} );

				//ON HOLD
				var tablesix = $('#examplesix').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
						type : "POST",
						data : {
							status : 'On Hold',
							nextStatus : 'New Order'
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//CANCELLED
				var tableseven = $('#exampleseven').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
						type : "POST",
						data : {
							status : 'Cancelled',
							nextStatus : 'New Order'
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" }]
				} );

				//ALL PRODUCTS
				var tableeight = $('#exampleeight').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
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
									'<tr class="group"><td class="delback"colspan="14">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12,13 ] } ],
					"aoColumns": [
						{ "sWidth": "5%" }, 
						{ "sWidth": "5%" },
						{ "sWidth": "2%" }, 
						{ "sWidth": "3%" },
						{ "sWidth": "2%" },
						{ "sWidth": "20%" },
						{ "sWidth": "12%" },
						{ "sWidth": "3%" },
						{ "sWidth": "15%" },
						{ "sWidth": "5%" },
						{ "sWidth": "3%" },
						{ "sWidth": "15%" },
						{ "sWidth": "5%" }
					]
				} );

				//CRM
				var tablenine = $('#examplenine').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"buttons": [
						
					],
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"../order/fetch.php",
						type : "POST",
						data : {
							status : 'CRM',
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12 ] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" }]
				} );

				//SEARCH FUNCTION
				$('#orderSearchText').keyup(function(){
					tableone.search($(this).val()).column(0).draw() ;
					tabletwo.search($(this).val()).column(0).draw() ;
					tablethree.search($(this).val()).column(0).draw() ;
					tablefour.search($(this).val()).column(0).draw() ;
					tablefive.search($(this).val()).column(0).draw() ;
					tablesix.search($(this).val()).column(0).draw() ;
					tableseven.search($(this).val()).column(0).draw() ;
					tableeight.search($(this).val()).column(0).draw() ;
					tablenine.search($(this).val()).column(0).draw() ;
				});

				//IMAGE FETCH
				$(document).on('click','#tableImage',function(event){
					event.preventDefault();
					var per_id=$(this).data('id');
					$('#content-data').html('');
					$.ajax({
						url:'../order/modal/orderImage.php',
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

				//NEW ORDER
				$(document).on('click','#newOrderAdd',function(event){
					event.preventDefault();
					$('#add-order-content-data').html('');
					var id=$(this).data('id');
					$.ajax({
						type:'POST',
						url:'../order/addNewOrder.php',
						data:{id:id}
					}).done(function(data){
						$('#add-order-content-data').html('');
						$('#add-order-content-data').html(data);
					}).fail(function(){
						$('#add-order-content-data').html('<p>Error</p>');
					});
				});

				//EDIT
				$(document).on('click','#orderEdit',function(event){
					event.preventDefault();
					$('#edit-order-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/editOrder.php'
					}).done(function(data){
						$('#edit-order-content-data').html('');
						$('#edit-order-content-data').html(data);
					}).fail(function(){
						$('#edit-order-content-data').html('<p>Error</p>');
					});
				});

				//ZOHO ORDER
				$(document).on('click','#newZohoOrderAdd',function(event){
					event.preventDefault();
					$('#add-zoho-order-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/zoho.php'
					}).done(function(data){
						$('#add-zoho-order-content-data').html('');
						$('#add-zoho-order-content-data').html(data);
					}).fail(function(){
						$('#add-zoho-order-content-data').html('<p>Error</p>');
					});
				});

				//ADD COMMENT
				$(document).on('click','#newCommentAdd',function(event){
					event.preventDefault();
					$('#add-comment-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/modal/addNewComment.php'
					}).done(function(data){
						$('#add-comment-content-data').html('');
						$('#add-comment-content-data').html(data);
					}).fail(function(){
						$('#add-comment-content-data').html('<p>Error</p>');
					});
				});

				//CHANGE STATUS - NEXT
				$(document).on('click','#statusChangeNext',function(event){
					if(confirm("Are you sure changing status?")){
						event.preventDefault();
						var statusid = $(this).attr('data-id');
						$.ajax({
							url     : '../order/statusChange.php',
							method  : 'POST',
							dataType: 'json',
							data    : {statusid : statusid},
							success : function(response)
							{
								if(response.index == 1){
									swal({
										title: 'Status Changed',
										text: 'Order Status is Changed Succesfully',
										type: 'success',
										confirmButtonColor: '#57a94f',
										allowOutsideClick: true
									});
										$('#exampleone').DataTable().ajax.reload();
										$('#exampletwo').DataTable().ajax.reload();
										$('#examplethree').DataTable().ajax.reload();
										$('#examplefour').DataTable().ajax.reload();
										$('#examplefive').DataTable().ajax.reload();
										$('#examplesix').DataTable().ajax.reload();
										$('#exampleseven').DataTable().ajax.reload();
										$('#exampleeight').DataTable().ajax.reload();
										$('#examplenine').DataTable().ajax.reload();
								}else if (response.index == 2){
									_markMaterialAvailable();
								}else if (response.index == 3){
									_staffEntry();
								}
								else{
									console.log('AUL AUL AUL');
								}
							}
						});
					}
					else{
						return false;
					}
				});

				//CHANGE STATUS - PREVIOUS
				$(document).on('click','#statusChangePrev',function(event){
					if(confirm("Are you sure changing status?")){
						event.preventDefault();
						var statusPrev = $(this).attr('data-id');
						$.ajax({
							url     : '../order/statusChange.php',
							method  : 'POST',
							dataType: 'json',
							data    : {statusPrev : statusPrev},
							success : function(response){
								if (response.index == 1){
									swal({
										title: 'Status Changed',
										text: 'Order Status is Changed Succesfully',
										type: 'success',
										confirmButtonColor: '#57a94f',
										allowOutsideClick: true
									});
									$('#exampleone').DataTable().ajax.reload();
									$('#exampletwo').DataTable().ajax.reload();
									$('#examplethree').DataTable().ajax.reload();
									$('#examplefour').DataTable().ajax.reload();
									$('#examplefive').DataTable().ajax.reload();
									$('#examplesix').DataTable().ajax.reload();
									$('#exampleseven').DataTable().ajax.reload();
									$('#exampleeight').DataTable().ajax.reload();
								}
							}
						});
					}
					else{
						return false;
					}
				});

				//MATERIAL LPO CONFIRMATION
				$(document).on('click','#_materialLpo',function(event){
					event.preventDefault();
					var id=$(this).data('id');
					$('#material-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/materialLpoModal.php',
						data:'id='+id,
						dataType:'html'
					}).done(function(data){
						$('#material-content-data').html('');
						$('#material-content-data').html(data);
					}).fail(function(){
						$('#material-content-data').html('<p>Error</p>');
					});
				});

				//CHANGE STATUS - BUTTON
				$(document).on('click','#changeStatus',function(event){
					event.preventDefault();
					$('#status-change-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/modal/statusModal.php'
					}).done(function(data){
						$('#status-change-content-data').html('');
						$('#status-change-content-data').html(data);
					}).fail(function(){
						$('#status-change-content-data').html('<p>Error</p>');
					});
				});

				//WARNING ALERT
				function _markMaterialAvailable(){
					swal({
						title: "Mark Material",
						text: "Please confirm material availability before changing status",
						type: "warning",
						confirmButtonClass: "btn btn-danger"
					});
				}

				//SUCCESS ALERT
				function _statusChanged(){
					swal({
						title: 'Status Changed',
						text: 'Order Status is Changed Succesfully',
						type: 'success',
						confirmButtonColor: '#57a94f',
						allowOutsideClick: true
					},
					function(){
						$.noConflict();
						$('#exampleone').DataTable().ajax.reload();
						$('#exampletwo').DataTable().ajax.reload();
						$('#examplethree').DataTable().ajax.reload();
						$('#examplefour').DataTable().ajax.reload();
						$('#examplefive').DataTable().ajax.reload();
						$('#examplesix').DataTable().ajax.reload();
						$('#exampleseven').DataTable().ajax.reload();
						$('#exampleeight').DataTable().ajax.reload();
					});
				}

				//WARNING ALERT
				function _staffEntry(){
					swal({
						title: "Add Staff",
						text: "Please add staff before marking next",
						type: "warning",
						confirmButtonClass: "btn btn-danger",
						allowOutsideClick: true
					},
					function(){
						$('#orderStaffModal').modal('show');
						$('#add-order-staff-content-data').html('');
						$.ajax({
							type:'POST',
							url:'../order/addOrderStaff.php'
						}).done(function(data){
							$('#add-order-staff-content-data').html('');
							$('#add-order-staff-content-data').html(data);
						}).fail(function(){
							$('#add-order-staff-content-data').html('<p>Error</p>');
						});
					});
				}

				$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                	localStorage.setItem('activeTab', $(e.target).attr('href'));
				});
				var activeTab = localStorage.getItem('activeTab');
				if(activeTab){
					$('#myTab a[href="' + activeTab + '"]').tab('show');
				}
			});
		</script>
	</body>
</html>