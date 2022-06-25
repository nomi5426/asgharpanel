<?php
session_start();
include "../base/db.php";
include '../base/deliveryNoteDownload.php';
if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) && (!isset($_SESSION['_factoryLogin'])) )
{ 
  date_default_timezone_set('Asia/Dubai');
  header("Location:index.php");
  app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt Admin User");
}
?>
<!DOCTYPE html>
<html lang="en">
	<?php include "../header/header_css.php"; ?>
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
								<h4 class="content-title mb-0 my-auto">Delivery Scheduler</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ View</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="mb-3 mb-xl-0">
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
									<p class="tx-12 tx-gray-500 mb-2">Segregated with Destination</p>
								</div>
								<div class="card-body">
									<div class="panel panel-primary tabs-style-2">
										<div class=" tab-menu-heading">
											<div class="tabs-menu" id="tabId">
												<!-- Tabs -->
												<ul class="nav panel-tabs main-nav-line nav-justified">
													<li class="nav-item"><a href="#DXB" class="nav-link active" data-toggle="tab">DXB</a></li>
													<li class="nav-item"><a href="#SHJ" class="nav-link" data-toggle="tab">SHJ</a></li>
													<li class="nav-item"><a href="#AJM" class="nav-link" data-toggle="tab">AJM</a></li>
													<li class="nav-item"><a href="#AUH" class="nav-link" data-toggle="tab">AUH</a></li>
													<li class="nav-item"><a href="#UAQ" class="nav-link" data-toggle="tab">UAQ</a></li>
													<li class="nav-item"><a href="#RAK" class="nav-link" data-toggle="tab">RAK</a></li>
													<li class="nav-item"><a href="#FUJ" class="nav-link" data-toggle="tab">FUJ</a></li>
													<li class="nav-item"><a href="#AAN" class="nav-link" data-toggle="tab">AAN</a></li>
													<li class="nav-item"><a href="#Western" class="nav-link" data-toggle="tab">Western</a></li>
												</ul>
											</div>
										</div>
										<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
											<div class="tab-content">
												<div class="tab-pane active" id="DXB">
													<div class="table-responsive">
														<table id="exampleone" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="SHJ">
													<div class="table-responsive">
														<table id="exampletwo" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="AJM">
													<div class="table-responsive">
														<table id="examplethree" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="AUH">
													<div class="table-responsive">
														<table id="examplefour" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="UAQ">
													<div class="table-responsive">
														<table id="examplefive" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="RAK">
													<div class="table-responsive">
														<table id="examplesix" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="FUJ">
													<div class="table-responsive">
														<table id="exampleseven" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="AAN">
													<div class="table-responsive">
														<table id="exampleeight" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="tab-pane" id="Western">
													<div class="table-responsive">
														<table id="examplenine" class="testclass table key-buttons text-md-nowrap">
															<thead>
																<tr>
																	<th class="border-bottom-0">Invoice ID</th>
																	<th class="border-bottom-0">Del/Date</th>
																	<th class="border-bottom-0">D/G</th>
																	<th class="border-bottom-0">Status</th>
																	<th class="border-bottom-0">D/L</th>
																	<th class="border-bottom-0">Item</th>
																	<th class="border-bottom-0">Quantity</th>
																	<th class="border-bottom-0">Consultant</th>
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
			</div>
			<?php "../footer/footer.php";?>
		</div>
		<!-- End Page -->

		<script type="text/javascript">
			$(document).ready(function() {
				var tableone = $('#exampleone').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Dubai',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [0,1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tabletwo = $('#exampletwo').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Sharjah',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );


				var tablethree = $('#examplethree').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Ajman',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tablefour = $('#examplefour').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Abu Dhabi',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tablefive = $('#examplefive').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'UAQ',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tablesix = $('#examplesix').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Ras al Khaimah',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tableseven = $('#exampleseven').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Fujairah',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tableeight = $('#exampleeight').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Al Ain',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
				} );

				var tablenine = $('#examplenine').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_delivery.php",
						type : "POST",
						data : {
							deliveryCity : 'Western',
						}
					},
					"order": [[ 1, "desc" ]],
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null; 
						api.column(1, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
									'<tr class="group"><td class="delback"colspan="08">'+'<strong> INVOICE ID : '+group+'</strong></td></tr>'
								);
								last = group;
							}
						} );
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [1,2,3,4,5,6,7] } ],
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "5%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "2%" },{ "sWidth": "5%" }]
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
					tablenine.search($(this).val()).column(0).draw() ;
				});

			} );
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

		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
	</body>
</html>