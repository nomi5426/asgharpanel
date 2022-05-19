<?php
session_start();
include "../base/db.php";
include '../base/deliveryNoteDownload.php';
if(!isset($_SESSION['_factoryLogin'])){header('Location:../index.php');}
//LOG
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
		<!-- Page -->
		<div class="page">
			<!-- main-content opened -->
			<?php include "../header/header.php";?>
			<div class="main-content horizontal-content">
				<!-- container opened -->
				<div class="container">
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								<h4 class="content-title mb-0 my-auto">Order</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Manage Order</span>
							</div>
						</div>
					</div>
					<!-- breadcrumb -->
					<!-- row opened -->
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
												<ul class="nav panel-tabs main-nav-line nav-justified">
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
				<!--MODAL OPEN-->				
				<!--IMAGE MODAL-->
				<div class="modal effect-scale show" id="imagemodalone">
					<div class="modal-dialog-new-order modal-dialog-centered" role="document">
						<div id="content-data"></div>
					</div>
				</div>
				<!-- MATERIAL LPO MODAL -->
				<div class="modal effect-scale show" id="materialLpoModal">
					<div class="modal-dialog" role="document">
						<div id="material-content-data"></div>
					</div>
				</div>
				<!--MODAL CLOSED-->
			</div>
			<!-- main-content closed -->
			<?php include "../footer/footer.php"; ?>
		</div>

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
					"aoColumns": [
						{ "sWidth": "5%" }, 
						{ "sWidth": "5%" },
						{ "sWidth": "2%" }, 
						{ "sWidth": "3%" },
						{ "sWidth": "2%" },
						{ "sWidth": "25%" },
						{ "sWidth": "15%" },
						{ "sWidth": "3%" },
						{ "sWidth": "20%" },
						{ "sWidth": "5%" },
						{ "sWidth": "3%" },
						{ "sWidth": "15%" },
						{"sWidth":"15%"}
					]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{"sWidth":"15%"}]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{"sWidth":"15%"}]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{"sWidth":"15%"}]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "10%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" }]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{"sWidth":"15%"}]
				} );

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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "25%" },{ "sWidth": "15%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{"sWidth":"15%"}]
				} );

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
						{ "sWidth": "25%" },
						{ "sWidth": "10%" },
						{ "sWidth": "3%" },
						{ "sWidth": "20%" },
						{ "sWidth": "5%" },
						{ "sWidth": "3%" },
						{"sWidth":"15%"},
						{ "sWidth": "8%" },
						{"sWidth":"15%"}
					]
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

			//Change Status
			$(document).on('click','#statusChangeNext',function(event){
				if(confirm("Are you sure changing status?")){
					event.preventDefault();
					var statusid = $(this).attr('data-id');
					$.ajax({
						url     : '../order/statusChange.php',
						method  : 'POST',
						data    : {statusid : statusid},
						success : function(response)
						{
							if(response.index == 2){
								// alert('Mark Material Available');
								_markMaterialAvailable();
							}else if (response.index == 1){
								// alert('Order Status has been Changed')
								_statusChanged();
								$('#exampleone').DataTable().ajax.reload();
								$('#exampletwo').DataTable().ajax.reload();
								$('#examplethree').DataTable().ajax.reload();
								$('#examplefour').DataTable().ajax.reload();
								$('#examplefive').DataTable().ajax.reload();
								$('#examplesix').DataTable().ajax.reload();
								$('#exampleseven').DataTable().ajax.reload();
								$('#exampleeight').DataTable().ajax.reload();
							}else if (response.index == 3){
								// alert('Add Staff made The Product');
								_staffEntry();
							}
						}
					});
				}
				else{
					return false;
				}
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
					confirmButtonColor: '#57a94f'
				});
			}
			//WARNING ALERT
			function _staffEntry(){
				swal({
					title: "Add Staff",
					text: "Please add staff before marking next",
					type: "warning",
					confirmButtonClass: "btn btn-danger"
				});
			}
			//MATERIAL
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
		</script>

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="ti-angle-double-up"></i></a>

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

		<!-- Sweet-alert js  -->
		<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="../assets/js/sweet-alert.js"></script>

		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>

		<!-- Internal Form-validation js -->
		<script src="../assets/js/form-validation.js"></script>
	</body>
</html>