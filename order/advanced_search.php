<?php
    session_start();
    if((!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin']))&& (!isset($_SESSION['_factoryLogin'])))
    {
        header("Location:../index.php");
    }
    include "../base/db.php";
    include '../base/deliveryNoteDownload.php';

    function loadBranch(){
        global $conn;
        $branchOutput='';   
        $branchSqlQuery = "SELECT * FROM branch ORDER BY branch_name";
        $result = mysqli_query($conn, $branchSqlQuery);
        $branchOutput .= '<option value="">Choose Branch</option>';
        while($row = mysqli_fetch_array($result)){
            $branchOutput .= '<option value = "'.$row["branch_name"].'">'.$row["branch_name"].'</option>';
        }
        return $branchOutput;
    }

    function loadOrderStatus(){
        global $conn;
        $statusOutput='';   
        $statusSqlQuery = "SELECT * FROM order_status";
        $result = mysqli_query($conn, $statusSqlQuery);
        $statusOutput .= '<option value="">Choose Status</option>';
        while($row = mysqli_fetch_array($result)){
            $statusOutput .= '<option value = "'.$row["status_name"].'">'.$row["status_name"].'</option>';
        }
        return $statusOutput;
    }

    function loadDeliveryLocation(){
        global $conn;
        $cityOutput='';   
        $citySqlQuery = "SELECT * FROM delivery_city";
        $result = mysqli_query($conn, $citySqlQuery);
        $cityOutput .= '<option value="">Choose Delivery City</option>';
        while($row = mysqli_fetch_array($result)){
            $cityOutput .= '<option value = "'.$row["city_name"].'">'.$row["city_name"].'</option>';
        }
        return $cityOutput;
    }

    function loadSalesPerson(){
        global $conn;
        $salesPersonOutput='';
        $salesPersonSqlQuery = "SELECT firstname FROM user
                                WHERE sales_col = 1
                                AND active_status = 1
                                ORDER BY firstname ASC";
        $result = mysqli_query($conn, $salesPersonSqlQuery);
        $salesPersonOutput .= '<option value="">Choose Sales Consultant</option>';
        while($row = mysqli_fetch_array($result)){
            $salesPersonOutput .= '<option value = "'.$row["firstname"].'">'.$row["firstname"].'</option>';
        }
        return $salesPersonOutput;
    }
?>
<!DOCTYPE html>
<html lang="en">
	<?php include "../header/header_css.php"; ?>
	<?php include "../header/header.php"; ?>
	<body class="main-body">
		<div class="page">
			<div class="main-content horizontal-content">
				<div class="container">
					<div class="breadcrumb-header justify-content-between">
						<div class="my-auto">
							<div class="d-flex">
								<h4 class="content-title mb-0 my-auto">Advanced Search</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ with All Inputs</span>
							</div>
						</div>
					</div>
					<div class="row row-sm justify-content-center">
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Branch / Company
									</div>
								</div>
								<select value='Order From' name="branchFrom" id="branchFrom" class="SlectBox form-control">
									<?php echo loadBranch(); ?>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Order Status
									</div>
								</div>
								<select value='Order Status' name="orderStatus" id="orderStatus" class="SlectBox form-control">
									<?php echo loadOrderStatus(); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Sales Consultant
									</div>
								</div>
								<select value="Sales Consultant" name="salesconsultant" id="salesconsultant" class="SlectBox form-control">
									<?php echo loadSalesPerson(); ?>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Delivery City
									</div>
								</div>
								<select value='Deliver To' name="deliverylocation" id="deliverylocation" class="SlectBox form-control">
									<?php echo loadDeliveryLocation(); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Date From
									</div>
								</div>
									<input class="form-control fc-datepicker" name="search_fromdate" id="search_fromdate" placeholder="Delivery Date" type="text">
							</div>
						</div>
						<div class="col-md-4 col-xl-4 col-xs-4 col-sm-4">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Date to 
									</div>
								</div>
									<input class="form-control fc-datepicker" name="search_todate" id="search_todate" placeholder="Delivery Date" type="text">
							</div>
						</div>
					</div>
					<div class="row row-sm justify-content-center">
						<div>
							<div class="input-group mb-3">
								<input class="btn btn-primary mr-2 btn-with-icon" type='button' id="btn_search" value="Search">
							</div>
						</div>
					</div>						  
					<div class="row row-sm">
						<div class="col-xl-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table text-md-nowrap" id="exampleone">
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
													<th class="border-bottom-0">Status</th>
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
				</div>
			</div>

			<!-- Image Modal -->
			<div class="modal effect-scale show" id="imagemodalone">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div id="content-data"></div>
				</div>
			</div>

			<?php include "../footer/footer.php"?>

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<script type="text/javascript">

			$(document).ready(function() {
				var tableone = $('#exampleone').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	false,
					"dom": 'Bfrtip',
					"buttons": [
						'copy', 'csv', 'pdf', 'print'
					],
					"iDisplayLength"	:	100,
					"processData": false,
					"ajax": {
						url  :"fetch_advanced_order.php",
						type : "POST",
						data : function(data){
							var status = $('#orderStatus').val();
							var from = $('#branchFrom').val();
							var salesConsultant = $('#salesconsultant').val();
							var deliveryCity = $('#deliverylocation').val();
							var from_date = $('#search_fromdate').val();
							var to_date = $('#search_todate').val();

							data.orderStatus = status;
							data.branchId = from;
							data.salesconsultant = salesConsultant;
							data.deliverylocation = deliveryCity;
							data.searchByFromdate = from_date;
							data.searchByTodate = to_date;
						}
					},
					"rowCallback": function( row, data, index ) {
						if ( data[7] == "Sharaf DG" ){
							$('td', row).css('background-color', '#b5b5de');
						}
						else if ( data[7] == "NooN" ){
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
					"aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "30%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "7%" },{ "sWidth": "3%" },{ "sWidth": "20%" },{"sWidth":"12%"}]				 
				} );

				//SEARCH BUTTON
				$('#btn_search').click(function(){
					tableone.draw();
				});
			} );

			//IMAGE
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

		</script>

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="ti-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="../assets/plugins/jquery/jquery.min.js"></script>

		<!--Internal Sumoselect js-->
		<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>
		<!-- Internal Select2 js -->
		<script src="../assets/js/select2.js"></script>
    	<script src="../assets/plugins/select2/js/select2.min.js"></script>
		<!-- Internal Form-elements js -->
		<script src="../assets/js/advanced-form-elements.js"></script>
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
		<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../assets/plugins/rating/jquery.barrating.js"></script>
		<!-- Internal Modal js-->
		<script src="../assets/js/modal.js"></script>
		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
		<script src="../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
		<script type="text/javascript">
		$( ".fc-datepicker" ).datepicker({
			"dateFormat": "yy-mm-dd",
			"changeYear": true
		});
 		</script>
	</body>
</html>