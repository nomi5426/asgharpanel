<?php
    include "../../base/db.php";

    function loadOrder(){
        global $conn;
        $statusOutput='';   
        $statusSqlQuery = "SELECT * FROM order_status";
        $result = mysqli_query($conn, $statusSqlQuery);
        while($row = mysqli_fetch_array($result)){
            $statusOutput .= '<option value = "'.$row["status_name"].'">'.$row["status_name"].'</option>';
        }
        return $statusOutput;
    }
?>
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h5 class="modal-title">Status Change</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>              
        <div class="modal-body">
            <form id="formNewStatus" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div>
                            <div class="input-group mb-3">
                                <select name="filterStatus" id="filterStatus" class="SlectBox form-control">
                                    <option value="Select Order Status" selected>Select Order Status</option>
                                        <?php
                                            $statusSqlQuery = "SELECT * FROM order_status WHERE NOT (status_name = 'Pending')";
                                            $result = mysqli_query($conn, $statusSqlQuery);
                                            while($row = mysqli_fetch_array($result)){
                                        ?>
                                    <option value="<?= $row['status_name'];?>"><?=$row['status_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <select name="filterInvoice" id="filterInvoice"  class="form-control select2-show-search select2-dropdown">
                                    <input hidden id="id" name="id" class="form-control"type="text">
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <select name="newStatus" id="newStatus"  class="form-control select2-show-search select2-dropdown">
                                    <option value="Select New Status" selected>Select New Status</option>
                                    <option value="New Order">New Order</option>
                                    <option value="In Production">In Production</option>
                                    <option value="Ready">Ready</option>
                                    <option value="Out for Delivery">Out for Delivery</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="On Hold">On Hold</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <textarea id="oldComment" disabled rows="3" type="text" class="form-control" name="oldComment" placeholder="Add Comment" value=""></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <textarea id="newComment" rows="3" type="text" class="form-control" name="newComment" value = "Add New Comment">Add New Comment</textarea>
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
    //HIDES BOTH OLD AND NEW COMMENT TEXT AREA TILL INVOICE IS SELECTED
    $('#oldComment').hide();
    $('#newComment').hide();
    $(document).ready(function(){
        //CHANGE ORDER STATUS
        $("#filterStatus").change(function(e){
            e.preventDefault();
            var stat = $(this).val();
            $.ajax({
                url:'../order/add_comment.php',
                method: 'POST',
                data: {selectedstat:stat},
                success:function(data){
                    $("#filterInvoice").html(data);
                }
            });
        });

        //FETCH ADDED COMMENT ALONG WITH THE INVOICE ID
        $("#filterInvoice").change(function(e){
            e.preventDefault();
            var id = $(this).find(':selected').attr('data-id');
            $.ajax({
                url:'../order/add_comment.php',
                method: 'POST',
                data: {id:id},
                success:function(data){
                    if(data === ""){
                        $('#newComment').fadeIn("slow");
                        $('#newComment').show();
                        $('#oldComment').hide();
                        $('#id').val(id);
                    }
                    else{
                        $('#oldComment').fadeIn("slow");
                        $('#oldComment').show();
                        $("#oldComment").html(data);
                        $('#newComment').fadeIn("slow");
                        $('#newComment').show();
                        $('#id').val(id);
                    }
                }
            });
        });
        
        //FORM SUBMIT
        $('#formNewStatus').on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                var id = $('#id').val();
                var newstatus = $('#newStatus').val();
                var currentstatus = $('#filterStatus').val();
                var newcomment = $('#newComment').val();
                $.ajax({
                    type: "POST",
                    url: '../order/statusChange.php',
                    dataType: 'json',
                    data: {s_id:id, newcomment:newcomment, currentstatus:currentstatus, newstatus:newstatus},
                    success: function(response){
                        if(response.index == 1){
                            errorHandling();
                            successAdded();
                        }
                        else if(response.index == 2){
                            _markMaterial();
                        }
                        else if(response.index == 3){
                            _markStaff();
                        }
                        else if(response.index == 0){
                            alert('Contact Support');
                        }
                    }
                });  
            }
        });

        //EMPTY ERROR HANDLING
        function errorHandling(){
            var flag = true;
            var _warningMessage;
            var _warningText = 'Mandatory fields should be filled';
            
            var _orderstatus = $("#filterStatus").val();
            var _invoiceId = $("#filterInvoice").val();
            var _newStatus = $("#newStatus").val();
            var _newComment = $("#newComment").val();

            if (_orderstatus == 'Select Order Status'){
                _warningMessage = "Select Order Status";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            else if (_invoiceId == 'Select Invoice ID'){
                _warningMessage = "Invoice ID is Left Empty";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            else if (_newStatus == 'Select New Status'){
                _warningMessage = "Select New Order Status";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            else if (_newComment == 'Add New Comment'){
                _warningMessage = "Why Status is Changed? Add Comment";
                _staffWarning(_warningMessage, _warningText);
                flag = false
            }
            return flag;
        }

        //WARNING EMPTY FIELDS
        function _staffWarning(_alertTitle, _alertText){
            swal({
                title: _alertTitle,
                text: _alertText,
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }

        //SUCCESS ALERT
        function successAdded(){
            swal({
                title: 'Status Changed',
                text: 'Please refer relevant table',
                type: 'success',
                confirmButtonColor: '#57a94f'
            },
            function reload(){
                location.reload();
            });
        }

        //ADD STAFF
        function _markStaff(){
            swal({
                title: 'Add Staff Before',
                text: 'Any In Production order should be added staff before proceeding',
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }

        //ADD MATERIAL
        function _markMaterial(){
            swal({
                title: "Mark Material",
                text: "Please confirm material availability before changing status",
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }

    });
</script>