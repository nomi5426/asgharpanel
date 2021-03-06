<?php

	//INCLUDE DIRECTORIES
	include "../base/db.php";
	include '../base/deliveryNoteDownload.php';

	//KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
	if(!isset($_SESSION['_deliveryLogin'])){
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
<?php include "../header/header_css.php"; ?>
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
                                                                <h4 class="content-title mb-0 my-auto">Order</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Approve Order</span>
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
                                                                                                        <li class="nav-item"><a href="#outfordelivery" class="nav-link active" data-toggle="tab">Out for Delivery</a></li>
                                                                                                </ul>
                                                                                        </div>
                                                                                </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                              <div class="tab-content">
                                                <div class="tab-pane active" id="outfordelivery">
                                                  <div class="table-responsive">
                                                    <table id="deliverytable" class="testclass table key-buttons text-md-nowrap">
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


                <script type="text/javascript">
                    $(document).ready(function() {
                        var table = $('#deliverytable').DataTable( {
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
                                    status : 'Out for Delivery'
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
                            "aoColumns": [{ "sWidth": "5%" }, { "sWidth": "5%" },{ "sWidth": "2%" }, { "sWidth": "3%" },{ "sWidth": "2%" },{ "sWidth": "20%" },{ "sWidth": "12%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "5%" },{ "sWidth": "3%" },{ "sWidth": "15%" },{ "sWidth": "3%" }]
                        } );
                        
                        $(document).on('click','#statusChangeNext',function(event){
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
                                            $('#deliverytable').DataTable().ajax.reload();
                                    }
                                    else{
                                        console.log('AUL AUL AUL');
                                    }
                                }
                            });
                        });
                    });
                </script>

                <!--NO MAN CODES-->
                <!-- <script>

        function getQueryParams(qs) {
	        qs = qs.split('+').join(' ');
	        var params =    {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;
                                        
        while (tokens = re.exec(qs)) {
                params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
        }
        	
        	return params;
				}
                                        
			window.onload = function (e) {
        var query = getQueryParams(document.location.search);
        // if (query.search  != null) {
        //         var table = $('#deliverytable').dataTable({ "retrieve": true }).api();
        //         table.search(query.search).draw();
        // }
			};

$(document).ready(function() {
var query = getQueryParams( document.location.search );
if ( query ) {
  if ( query.search ) {
    // $( "#deliverytable" ).val( query.search );
    var table = $('#deliverytable').val( query.search ).DataTable( {
                        "processing":   true,
                        "serverSide":   true,
                        "paging"    :   true,
                        "retrieve"  :   true,
                        // "searching" : true,
                        // "sDom": 'Brtip',
                        // "buttons": [
                        // ],
                        "iDisplayLength" : 100,
                        "ajax": {
                                url  :"../order/fetch.php",
                                type : "POST",
                                data : {
                                status : 'Out for Delivery',
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
                } );
    				table.search(query.search).draw();
					}
					}
					});

                </script> -->

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
                <!-- Sweet-alert js  -->
		<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="../assets/js/sweet-alert.js"></script>
                <!-- custom js -->
                <script src="../assets/js/custom.js"></script>
                <!-- Internal Modal js-->
                <script src="../assets/js/modal.js"></script>

        </body>
</html>