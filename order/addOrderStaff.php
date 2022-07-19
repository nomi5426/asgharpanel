<?php
    include "../base/db.php";

    //KEEP TRACK ON SESSION VARIABLES
    if(!session_id()) session_start();
    if( (!isset($_SESSION['_superAdminLogin'])) && (!isset($_SESSION['_adminLogin'])) && (!isset($_SESSION['_factoryLogin'])) && (!isset($_SESSION['_deliveryLogin']))){
        header('Location:../index.php');
    }

    if(isset($_SESSION['userName'])){
        $username = $_SESSION['userName'];
        $userDetail= $conn->query("SELECT * FROM user WHERE username='".$username."'");
        while($row = mysqli_fetch_assoc($userDetail)) {
            $_firstName = $row['firstname'];
            $_userRole = $row['userrole'];
			$_userName = $row['username'];
        }
    }

	function app_log($message){
        $logPath  = "../log/log_";
		date_default_timezone_set('Asia/Dubai');
		$logfile = $logPath.date('d-M-Y').'.log';
		file_put_contents($logfile, $message . "\n", FILE_APPEND);
	}

    function loadStaff(){
        global $conn;
        $staffOutput='';
        $staffSqlQuery='';
        if($_POST['prodStat'] == 'In Production'){
            $staffSqlQuery = 'SELECT * FROM staff WHERE staff_type = "Production" ORDER BY staff_name ASC';
        }else if($_POST['prodStat'] == 'Ready'){
            $staffSqlQuery = 'SELECT * FROM staff WHERE staff_type = "Delivery" ORDER BY staff_name ASC';
        }
        $result = mysqli_query($conn, $staffSqlQuery);
        $staffOutput .= '<option value = "Select Staff ID">Select Staff ID</option>';
        while($row = mysqli_fetch_array($result)){
            $staffOutput .= '<option value = "'.$row['id'].'">'.$row["staff_name"].'</option>';
        }
        return $staffOutput;
    }

    if(isset($_REQUEST['id'])){
        $id=intval($_REQUEST['id']);
        $sql="select * from product WHERE id=$id";
        $run_sql=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_array($run_sql)){
            $id=$row['id'];
            $itemDet = $row['invoiceId'].' - '.$row['pname'];
            $itemStat = $row['pstatus'];
        }
        ?>
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title">Add Who Made</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form id="formNewOrderStaff" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div>
                                <div class="input-group mb-3">
                                    <select disabled name="staffStatus" id="staffStatus" class="SlectBox form-control">
                                        <option value="<?php echo $itemStat;?>"><?php echo $itemStat ?></option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="input-group mb-3">
                                    <input hidden id="orderId" name="orderId" value="<?php echo $id;?>" class="form-control"type="text">
                                    <input disabled id="staffInvoice" name="staffInvoice" value="<?php echo $itemDet;?>" class="form-control"type="text">
                                </div>
                            </div>
                            <div>
                                <div class="input-group mb-3">
                                    <select name="staff_name[]" id="staff_name" multiple="multiple" class="form-control select2-show-search select2-dropdown">
                                        <?php echo loadStaff(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary btn-size">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }
    ?>

<!-- Internal Sumoselect js -->
<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>
<!-- Internal Select2 js -->
<!-- <script src="../assets/js/select2.js"></script> -->
<script src="../assets/plugins/select2/js/select2.min.js"></script>
<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>
<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#formNewOrderStaff').on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                var order_id = $('#orderId').val();
                var staff_id = $('#staff_name').val();
                $.ajax({
                    type: "POST",
                    url: '../order/add_staff_order.php',
                    dataType: 'json',
                    data: {order_id:order_id, staff_id:staff_id},
                    success: function(response){
                        if(response.index == 1){
                            _staffExists();
                        }else if(response.index == 2){
                            errorHandling();
                            $('#formNewOrderStaff').trigger("reset");
                            _staffAdded();
                        }else{
                            _staffExists();
                        }
                    }
                });
            }
        });

        //ERROR HANDLING
        function errorHandling(){
            var flag = true;
            var _warningMessage;
            var _warningText = "Mandatory Fields are Required to be Filled";

            var _orderstatus = $("#staffStatus").val();
            var _invoiceId = $("#staffInvoice").val();
            var _staffName = $("#staff_name").val();

            if (_orderstatus == 'Select Order Status'){
                _warningMessage = "Select Order with Status";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            else if (_invoiceId == 'Select Invoice ID'){
                _warningMessage = "Invoice ID is Left Empty";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            else if (_staffName == 'Select Staff ID'){
                _warningMessage = "Staff Name is Left Empty";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            // else{
            //     _staffAdded();
            // }
            return flag;
        }

        //WARNING ALERT
        function _staffWarning(_alertTitle, _alertText){
            swal({
                title: _alertTitle,
                text: _alertText,
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }

        //SUCCESS ALERT
        function _staffAdded(){
            swal({
                title: 'Staff Added',
                text: 'Succesfully Added to The Order',
                type: 'success',
                confirmButtonColor: '#57a94f'
            },
            function load(){
                location.reload();
            });
        }

        //WARNING ALERT
        function _staffExists(){
            swal({
                title: 'Staff Exists',
                text: 'Staff is Added to The Order Already',
                type: 'warning',
                confirmButtonClass: "btn btn-danger"
            });
        }
    });
</script>


