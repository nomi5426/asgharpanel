<?php
session_start();
if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) && (!isset($_SESSION['_factoryLogin'])) ){
	header("Location:../index.php");
}
include "../base/db.php";
include '../base/deliveryNoteDownload.php';
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
								<h4 class="content-title mb-0 my-auto">In Production</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ View</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="mb-3 mb-xl-0">
								<!-- <div class="btn-group dropdown">
									<button id="newOrderAdd" class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal" data-target="#newOrderModal" type="button">New Order</button>
								</div> -->
							</div>
						</div>
					</div>
					<!-- breadcrumb -->
					<!-- row opened -->
					<div class="row row-sm">
					<div class="col-xl-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table text-md-nowrap" id="exampletwo">
											<thead>
												<tr>
													<th class="border-bottom-0">IID</th>
													<th class="border-bottom-0">DEL/Date</th>
													<th class="border-bottom-0">D/G</th>
													<th class="border-bottom-0">City</th>
													<th class="border-bottom-0">D/L</th>
													<th class="border-bottom-0">Item</th>
													<th class="border-bottom-0">QTY</th>
													<th class="border-bottom-0">Note</th>
													<th class="border-bottom-0">Consult</th>
													<th class="border-bottom-0">Image</th>
													<th class="border-bottom-0">Comment</th>
													<th class="border-bottom-0">Print</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					

					<!--New Order Modal
					<div class="modal effect-scale show" id="newOrderModal">
						<div class="modal-dialog-new-order" role="document">
							<div id="add-order-content-data"></div>
						</div>
					</div> -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<!-- Image Modal -->
			<div class="modal effect-scale show" id="imagemodalone">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div id="content-data"></div>
				</div>
			</div>

			<?php include "../footer/footer.php" ?>

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<script>
			$(document).ready(function() {
				var tabletwo = $('#exampletwo').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_order.php",
						type : "POST",
						data : {
							status : 'In Production',
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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "30%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{"sWidth":"12%"}]
				} );

				$('#orderSearchText').keyup(function(){
					tabletwo.search($(this).val()).column(0).draw() ;
				});

			} );

			//Image Modal
			$(document).on('click','#tableImage',function(event){
				event.preventDefault();
				var per_id=$(this).data('id');
				$('#content-data').html('');
				$.ajax({
					url:'modal/orderImageSingle.php',
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

			// //Add New Order Modal
			// $(document).on('click','#newOrderAdd',function(event){
			// 	event.preventDefault();
			// 	$('#add-order-content-data').html('');
			// 	$.ajax({
			// 		type:'POST',
			// 		url:'modal/addNewOrder.php'
			// 	}).done(function(data){
			// 		$('#add-order-content-data').html('');
			// 		$('#add-order-content-data').html(data);
			// 	}).fail(function(){
			// 		$('#add-order-content-data').html('<p>Error</p>');
			// 	});
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

		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
	</body>
</html>