<?php
session_start();
require_once  "../base/db.php";
require_once  "../base/deliveryNoteDownload.php";

if( (!isset($_SESSION['login'])) && (!isset($_SESSION['salesLogin'])) )
{ 
  date_default_timezone_set('Asia/Dubai');
  header("Location:index.php");
  app_log("'".date('d-m-Y H:i:s')."' : Session is not set, Login Attempt Admin User");
}

//MODAL - LOAD MASTER CATEGORY
function loadMasterCat(){
    global $conn;
    $CatOutput='';
    $CatSqlQuery = "SELECT mas_cat_name FROM master_category";
    $result = mysqli_query($conn, $CatSqlQuery);
    $CatOutput .= '<option value = "Select Master Category">Select Master Category</option>';
    while($row = mysqli_fetch_array($result)){
        $CatOutput .= '<option value = "'.$row["mas_cat_name"].'">'.$row["mas_cat_name"].'</option>';
    }
    return $CatOutput;
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
								<h4 class="content-title mb-0 my-auto">Order Category</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Category Management</span>
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="mb-3 mb-xl-0">
							</div>
						</div>
						<div class="d-flex my-xl-auto right-content">
							<div class="pr-1 mb-3 mb-xl-0">
								<button id="newCatAdd" class="modal-effect btn btn-primary mr-2 btn-with-icon" data-effect="effect-scale" data-toggle="modal" data-target="#newCatModal" type="button"><i class="typcn typcn-document-add"></i>New Category</button>
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
										<h4 class="card-title mg-b-0">Manage Category</h4>
									</div>
									<p class="tx-12 tx-gray-500 mb-2">Main and Sub Category Listing</p>
								</div>
								<div class="card-body">
									<div class="panel panel-primary tabs-style-2">
										<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
											<div class="table-responsive">
												<table id="exampleone" class="testclass table key-buttons text-md-nowrap">
													<thead>
														<tr>
															<th class="border-bottom-0">Name</th>
															<th class="border-bottom-0">Master Category</th>
															<th style="text-align:center" class="border-bottom-0">Action</th>
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
				<!-- Container closed -->

				<!-- Add Category Modal -->
				<div class="modal effect-scale show" id="newCatModal">
					<div class="modal-dialog" role="document">
						<div id="add-cat-content-data"></div>
					</div>
				</div>

				<!-- Edit Category Modal -->
				<div class="modal effect-scale show" id="editCatModal">
					<div class="modal-dialog" role="document">
						<div id="edit-cat-content-data"></div>
					</div>
				</div>
			</div>
			<!-- main-content closed -->

			<?php "../footer/footer.php";?>
		</div>
		<!-- End Page -->

		<script>
			$(document).ready(function() {
				var tableone;
				var eagle;
				tableone = $('#exampleone').DataTable( {
					"processing": 	true,
					"serverSide": 	true,
					"paging"	:	true,
					"searching"	:	true,
					"sDom": 'Brtip',
					"iDisplayLength"	:	100,
					"ajax": {
						url  :"fetch_category.php",
						type : "POST"
					},
					"autoWidth": false,
					"aoColumnDefs": [{ "bSortable": false, "bSearchable": false, "aTargets": [0,1,2] } ],
					"aoColumns": [{ "sWidth": "30%" }, { "sWidth": "30%" },{ "sWidth": "40%" }]
				} );

				
				$('#orderSearchText').keyup(function(){
					tableone.search($(this).val()).column(0).draw() ;
				});

			} );

			//Add New Category Modal
			$(document).on('click','#newCatAdd',function(event){
				event.preventDefault();
				$('#add-cat-content-data').html('');
				var id=$(this).data('id');
				$.ajax({
					type:'POST',
					url:'addNewCategory.php',
					data:{id:id},
					dataType:'html'
				}).done(function(data){
					$('#add-cat-content-data').html(data);
				}).fail(function(){
					$('#add-cat-content-data').html('<p>Error</p>');
				});
			});

			//Edit Category Modal
			$(document).on('click','#_editCat',function(event){
				event.preventDefault();
				var id=$(this).data('id');
				$('#edit-cat-content-data').html('');
				$.ajax({
					type:'POST',
					url:'editCategory.php',
					data:'id='+id,
					dataType:'html'
				}).done(function(data){
					$('#edit-cat-content-data').html('');
					$('#edit-cat-content-data').html(data);
				}).fail(function(){
					$('#edit-cat-content-data').html('<p>Error</p>');
				});
        	});

			// //Edit Category Modal
			// $(document).on('click','#_editCat',function(event){
			// 	event.preventDefault();
			// 	var id=$(this).data('id');
			// 	$('#edit-cat-content-data').html('');
			// 	$.ajax({
			// 		type:'POST',
			// 		url:'../category/modal/editCategory.php',
			// 		data:'id='+id,
			// 		dataType:'html'
			// 	}).done(function(data){
			// 		$('#edit-cat-content-data').html('');
			// 		$('#edit-cat-content-data').html(data);
			// 	}).fail(function(){
			// 		$('#edit-cat-content-data').html('<p>Error</p>');
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

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>
	</body>
</html>