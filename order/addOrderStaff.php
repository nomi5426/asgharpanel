<?php
include "../base/db.php";

function loadStaff(){
    global $conn;
    $staffOutput='';
    $staffSqlQuery = "SELECT * FROM staff ORDER BY staff_name ASC";
    $result = mysqli_query($conn, $staffSqlQuery);
    $staffOutput .= '<option value = "Select Staff ID">Select Staff ID</option>';
    while($row = mysqli_fetch_array($result)){
        $staffOutput .= '<option value = "'.$row['id'].'">'.$row["staff_name"].'</option>';
    }
    return $staffOutput;
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
                            <select name="staffStatus" id="staffStatus" class="SlectBox form-control">
                                <option value="Select Order Status">Select Order Status</option>
                                <option value="In Production">In Production</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <select name="staffInvoice" id="staffInvoice"  class="form-control select2-show-search select2-dropdown">
                            </select>
                            <input hidden id="id" name="id" class="form-control"type="text">
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <select name="staff_name" id="staff_name"  class="form-control select2-show-search select2-dropdown">
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
        $("#staffStatus").change(function(e){
            e.preventDefault();
            var orderStatus = $(this).val();
            $.ajax({
                url:'../order/add_staff_order.php',
                method: 'POST',
                data: {orderStatus:orderStatus},
                success:function(data){
                    $("#staffInvoice").html(data);
                }
            });
        });

		$('#formNewOrderStaff').on('submit', function(e){
			e.preventDefault();
			if(errorHandling()){
                var order_id = $('#staffInvoice').val();
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

		//EMPTY FIELD - WARNING
        function _staffWarning(_alertTitle, _alertText){
            swal({
                title: _alertTitle,
                text: _alertText,
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }

		//STAFF ADDEDD - SUCCESS
        function _staffAdded(){
            swal({
                title: 'Staff Added',
                text: 'Succesfully Added to The Order',
                type: 'success',
                confirmButtonColor: '#57a94f'
            });
        }

		//STAFF EXISTS - WARNING
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

