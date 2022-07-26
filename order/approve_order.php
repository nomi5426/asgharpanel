<?php

	/*********************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: APPROVE PENDING ORDERS BY RELEVANT SALES OR ADMIN OR SUPER ADMIN
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
    session_start();
    if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_salesLogin'])) && (!isset($_SESSION['_factoryLogin'])) ){ 
        header("Location:../index.php");
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
                                <h4 class="content-title mb-0 my-auto">Pending Order</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Approve</span>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="pendingTable" class="testclass table key-buttons text-md-nowrap">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IMAGE MODAL -->
            <div class="modal effect-scale show" id="imagemodalone">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div id="content-data"></div>
                </div>
            </div>

            <!--EDIT ORDER MODAL-->
            <div class="modal effect-scale show" id="editOrderApproveModal">
                <div class="modal-dialog-edit-order" role="document">
                    <div id="edit-order-approve-content-data"></div>
                </div>
            </div>

            <?php include "../footer/footer.php"?>

        </div>
        <!-- End Page -->

        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
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
        <!-- Sweet-alert js  -->
		<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="../assets/js/sweet-alert.js"></script>
        <script>
            
            $(document).ready(function() {

                //INITIALIZING DATATABLE AS PENDINGTABLE AND FETCH ALL STATUS OF PENDING ORDERS
                //IF THE USER ROLE IS SALES, THEY WOULD BE VIEWING ONLY THE ORDERS WHICH WERE APPOINTED TO THEM
                //STATUS PENDING WILL BE SENT TO RETREIVE ALL PENDING STATUSES OF ORDERS
				var tableone = $('#pendingTable').DataTable( {
                    "processing": 	true,
                    "serverSide": 	true,
                    "paging"	:	true,
                    "searching"	:	true,
                    "sDom": 'rtip',
                    "iDisplayLength"	:	100,
                    "ajax": {
                        url  :"fetch_pending_order.php",
                        type : "POST",
                        data : {
                            status : 'Pending'
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

                $('#orderSearchText').keyup(function(){
                    tableone.search($(this).val()).column(0).draw() ;
                });

                //APPROVE ORDER
                $(document).on('click','#confirmOrder',function(event){
                    if(confirm("Are you sure approving order?")){
                        event.preventDefault();
                        var confirmOrder = $(this).attr('data-id');
                        $.ajax({
                            url     : '../order/statusChange.php',
                            method  : 'POST',
                            dataType: 'json',
                            data    : {confirmOrder : confirmOrder},
                            success : function(response){
                                if(response.index == 2){
                                    approvedSuccess();
                                }
                                else if(response.index == 3){
                                    addSalesAgreement();
                                }
                            }
                        });
                    }
                });

				//EDIT ORDER
				$(document).on('click','#editOrderApprove',function(event){
					event.preventDefault();
					var id=$(this).data('id');
					$('#edit-order-approve-content-data').html('');
					$.ajax({
						type:'POST',
						url:'../order/editOrderApprove.php',
						data:'id='+id,
						dataType:'html'
					}).done(function(data){
						$('#edit-order-approve-content-data').html('');
						$('#edit-order-approve-content-data').html(data);
					}).fail(function(){
						$('#edit-order-approve-content-data').html('<p>Error</p>');
					});
				});
            
                //SUCCESS - APPROVE SUCCESS AND RELOADS TABLE
                function approvedSuccess(){
                    swal({
                        title: 'Order is Approved',
                        text: 'Pending Order is sent to New Order',
                        type: 'success',
                        confirmButtonColor: '#57a94f'
                    },
                    function(){
                        $('#pendingTable').DataTable().ajax.reload();
                    });
                }

                //WARNING - SALES AGREEMENT IS MISSING
                function addSalesAgreement(){
                    swal({
                        title: "Sales Agreement is Missing",
                        text: "Please edit for adding Sales Agreement",
                        type: "warning",
                        confirmButtonClass: "btn btn-danger",
                        allowOutsideClick: true
                    });
                }

                //IMAGE MODAL
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
            } );
        </script>
    </body>
</html>