<?php
session_start();
if(!isset($_SESSION['salesLogin'])){header('Location:../index.php');}
?>
<!DOCTYPE html>
<html lang="en">
	<?php include "../header/header.php"; ?>
	<body class="main-body">
		<!-- Page -->
		<div class="page">
			<!-- main-content opened -->
			<div class="main-content horizontal-content">
				<!-- container opened -->
				<div class="container">
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								<h4 class="content-title mb-0 my-auto">Order</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Approve Order</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="pr-1 mb-3 mb-xl-0">
								<button type="button" class="btn btn-info btn-icon mr-2"><i class="mdi mdi-filter-variant"></i></button>
							</div>
							<div class="mb-3 mb-xl-0">
								<div class="btn-group dropdown">
									<button id="newOrderAdd" class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal" data-target="#newOrderModal" type="button">New Order</button>
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
										<h4 class="card-title mg-b-0">View All Order</h4>
									</div>
									<p class="tx-12 tx-gray-500 mb-2">Orders from All Status</p>
								</div>
								<div class="card-body">
									<div class="panel panel-primary tabs-style-2">
										<div class=" tab-menu-heading">
											<div class="tabs-menu" id="tabId">
												<!-- Tabs -->
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

					<!--Image Modal-->
					<div class="modal effect-scale show" id="imagemodalone">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div id="content-data"></div>
						</div>
					</div>

					<!--New Order Modal-->
					<div class="modal effect-scale show" id="newOrderModal">
						<div class="modal-dialog-new-order" role="document">
							<div id="add-order-content-data"></div>
						</div>
					</div>
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->
			<?php include "../footer/footer.php"; ?>
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

				var tableeight = $('#exampleeight').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"iDisplayLength"	:	100,
					"sDom": 'Brtip',
					"buttons": [
						
					],
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
									'<tr class="group"><td class="delback"colspan="13">'+'<strong> Delivery On : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [2,4,5,6,7,8,9,10,11,12] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" }]
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

			//Add New Order Modal
			$(document).on('click','#newOrderAdd',function(event){
				event.preventDefault();
				$('#add-order-content-data').html('');
				$.ajax({
					type:'POST',
					url:'../order/modal/addNewOrder.php'
				}).done(function(data){
					$('#add-order-content-data').html('');
					$('#add-order-content-data').html(data);
				}).fail(function(){
					$('#add-order-content-data').html('<p>Error</p>');
				});
			});

			//Add Comment Modal
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

			//Change Status
			$(document).on('click','#statusChangeNext',function(event){
				if(confirm("Are you sure changing status?")){
					event.preventDefault();
					var statusid = $(this).attr('data-id');
					$.ajax({
						url     : '../order/statusChange.php',
						method  : 'POST',
						data    : {statusid : statusid},
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

			$(document).on('click','#materialConfirm',function(event){
				if(confirm("Are you sure Confirming Material Availability?")){
					event.preventDefault();
					var materialid = $(this).attr('data-id');
					$.ajax({
						url     : '../order/statusChange.php',
						method  : 'POST',
						data    : {materialid : materialid},
						success : function(data)
						{
							$('#exampleone').DataTable().ajax.reload();
						}
					});
				}
				else{
					return false;
				}
			});

			//GET TAB TEXT
			// $(document).ready(function(){
				// $('#tabId').tabs({
				// 	select: function(e, ui){
				// 		alert($(ui.tab).text());
				// 	}
				// });
			// });
		</script>

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="ti-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="../assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

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

		<!-- eva-icons js -->
		<script src="../assets/js/eva-icons.min.js"></script>

		<!-- Horizontalmenu js-->
		<script src="../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

		<!-- Sticky js -->
		<script src="../assets/js/sticky.js"></script>

		<!-- Internal Select2 js-->
		<script src="../assets/plugins/select2/js/select2.min.js"></script>

		<!--Internal Sumoselect js-->
		<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>

		<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>

		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>
	</body>
</html>